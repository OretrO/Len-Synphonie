<?php

namespace App\Jobs;

use App\Models\Arrangement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GenerateArrangementAudio implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public int $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(public Arrangement $arrangement)
    {
        $this->onQueue('audio');
        // Load relationships to avoid N+1 queries
        $this->arrangement->load(['instruments', 'partition']);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Starting audio generation for arrangement', [
                'arrangement_id' => $this->arrangement->id,
                'arrangement_name' => $this->arrangement->name,
            ]);

            // Update status to processing
            $this->arrangement->update([
                'status' => 'processing',
                'audio_generation_error' => null,
            ]);

            // Get partition musicxml file
            $partition = $this->arrangement->partition;
            if (!$partition || !$partition->musicxml_file_path) {
                throw new \Exception('Partition or MusicXML file not found');
            }

            $musicXmlPath = Storage::disk('public')->path($partition->musicxml_file_path);
            if (!file_exists($musicXmlPath)) {
                throw new \Exception("MusicXML file not found: {$musicXmlPath}");
            }

            // Ensure audio storage directory exists
            Storage::disk('public')->makeDirectory('arrangements/' . $this->arrangement->id, 0755, true);

            // Generate output path
            $outputFilename = "arrangements/{$this->arrangement->id}/" . uniqid() . '.wav';
            $outputPath = Storage::disk('public')->path($outputFilename);
            $outputDir = dirname($outputPath);

            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            $command = $this->buildLenSymphonyCommand($musicXmlPath, $outputPath, $this->arrangement);

            Log::info('Executing LenSymphony command', [
                'command' => implode(' ', $command),
                'arrangement_id' => $this->arrangement->id,
            ]);

            // Execute command
            $this->executeLenSymphony($command);

            // Verify output file was created
            if (!file_exists($outputPath)) {
                throw new \Exception("LenSymphony did not generate output file: {$outputPath}");
            }

            // Update arrangement with new audio file path
            $this->arrangement->update([
                'audio_file_path' => $outputFilename,
                'status' => 'completed',
            ]);

            Log::info('Audio generation completed successfully', [
                'arrangement_id' => $this->arrangement->id,
                'output_path' => $outputFilename,
            ]);

        } catch (\Exception $exception) {
            Log::error('Audio generation failed', [
                'arrangement_id' => $this->arrangement->id,
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            // Update arrangement with error status
            $this->arrangement->update([
                'status' => 'failed',
                'audio_generation_error' => $exception->getMessage(),
            ]);

            // Rethrow for queue retry logic
            throw $exception;
        }
    }

    /**
     * Build the LenSymphony command based on arrangement configuration.
     *
     * LenSymphony CLI Format:
     * java -jar lensymphony.jar -i input.xml -o output.wav -v 1:PIANO -v 2:VIOLIN ...
     *
     * @param string $musicXmlPath Path to the MusicXML file
     * @param string $outputPath Path where the WAV file should be saved
     * @param Arrangement $arrangement The arrangement being processed
     * @return array Command array for Process class
     */
    private function buildLenSymphonyCommand(string $musicXmlPath, string $outputPath, Arrangement $arrangement): array
    {
        // Detect Java path based on OS
        $javaPath = $this->getJavaPath();
        
        $command = [
            $javaPath,
            '-jar',
            base_path('java/lensymphony.jar'),
            '-i',
            $musicXmlPath,
            '-o',
            $outputPath,
        ];

        // Add voice mappings: -v 1:SAXOPHONE -v 2:HORN etc.
        // Instruments are passed in order with 1-based indices
        // Ensure instruments are loaded
        if (!$this->arrangement->relationLoaded('instruments')) {
            $this->arrangement->load('instruments');
        }
        
        if ($this->arrangement->instruments->count() > 0) {
            // Sort instruments by track_number from pivot
            $instruments = $this->arrangement->instruments->sortBy(function($instrument) {
                return $instrument->pivot->track_number ?? 999;
            });
            
            $trackNumber = 1;
            foreach ($instruments as $instrument) {
                // Convert instrument name to uppercase for LenSymphony enum
                // Expected format: PIANO, VIOLIN, SAXOPHONE, etc.
                $command[] = '-v';
                $instrumentName = strtoupper(str_replace([' ', '_'], '', $instrument->name));
                $command[] = $trackNumber . ':' . $instrumentName;
                $trackNumber++;
            }
        }

        return $command;
    }

    /**
     * Execute the LenSymphony command.
     *
     * @param array $command
     * @throws ProcessFailedException
     */
    private function executeLenSymphony(array $command): void
    {
        $process = new Process($command);
        $process->setTimeout($this->timeout);
        $process->setIdleTimeout($this->timeout);

        try {
            $process->mustRun();

            $output = $process->getOutput();
            $errorOutput = $process->getErrorOutput();

            Log::debug('LenSymphony command output', [
                'output' => $output,
                'error_output' => $errorOutput,
            ]);

        } catch (ProcessFailedException $exception) {
            Log::error('LenSymphony process failed', [
                'command' => $process->getCommandLine(),
                'exit_code' => $process->getExitCode(),
                'output' => $process->getOutput(),
                'error_output' => $process->getErrorOutput(),
            ]);

            throw $exception;
        }
    }

    /**
     * Get Java executable path based on OS.
     * Supports Java 24+ and automatically detects available versions.
     * 
     * @return string
     */
    private function getJavaPath(): string
    {
        // Check if JAVA_HOME is set
        $javaHome = env('JAVA_HOME');
        if ($javaHome) {
            $separator = DIRECTORY_SEPARATOR;
            $javaPath = rtrim($javaHome, $separator) . $separator . 'bin' . $separator . 'java';
            if (PHP_OS_FAMILY === 'Windows') {
                $javaPath .= '.exe';
            }
            if (file_exists($javaPath)) {
                Log::info('Using Java from JAVA_HOME', ['path' => $javaPath]);
                return $javaPath;
            }
        }

        // Try common Java paths on Windows (supports Java 24, 25, and other versions)
        if (PHP_OS_FAMILY === 'Windows') {
            $possiblePaths = [];
            
            // Check Program Files (x86) first (where user has Java installed)
            $x86Base = 'C:\\Program Files (x86)\\Java\\';
            if (is_dir($x86Base)) {
                $dirs = scandir($x86Base);
                foreach ($dirs as $dir) {
                    if ($dir !== '.' && $dir !== '..' && is_dir($x86Base . $dir)) {
                        // Check for jdk-* or jre-* directories
                        if (preg_match('/^(jdk|jre)-/', $dir)) {
                            $javaPath = $x86Base . $dir . '\\bin\\java.exe';
                            if (file_exists($javaPath)) {
                                $possiblePaths[] = $javaPath;
                            }
                        }
                    }
                }
            }
            
            // Check Program Files
            $pfBase = 'C:\\Program Files\\Java\\';
            if (is_dir($pfBase)) {
                $dirs = scandir($pfBase);
                foreach ($dirs as $dir) {
                    if ($dir !== '.' && $dir !== '..' && is_dir($pfBase . $dir)) {
                        if (preg_match('/^(jdk|jre)-/', $dir)) {
                            $javaPath = $pfBase . $dir . '\\bin\\java.exe';
                            if (file_exists($javaPath)) {
                                $possiblePaths[] = $javaPath;
                            }
                        }
                    }
                }
            }
            
            // Also try specific versions (24, 25)
            $specificPaths = [
                'C:\\Program Files\\Java\\jdk-25\\bin\\java.exe',
                'C:\\Program Files\\Java\\jre-25\\bin\\java.exe',
                'C:\\Program Files (x86)\\Java\\jdk-25\\bin\\java.exe',
                'C:\\Program Files (x86)\\Java\\jre-25\\bin\\java.exe',
                'C:\\Program Files\\Java\\jdk-24\\bin\\java.exe',
                'C:\\Program Files\\Java\\jre-24\\bin\\java.exe',
                'C:\\Program Files (x86)\\Java\\jdk-24\\bin\\java.exe',
                'C:\\Program Files (x86)\\Java\\jre-24\\bin\\java.exe',
            ];
            
            $possiblePaths = array_merge($possiblePaths, $specificPaths);
            
            // Try to find the highest version (prefer 25, then 24, then others)
            usort($possiblePaths, function($a, $b) {
                // Extract version numbers
                preg_match('/jdk-(\d+)|jre-(\d+)/', $a, $matchA);
                preg_match('/jdk-(\d+)|jre-(\d+)/', $b, $matchB);
                $versionA = (int)($matchA[1] ?? $matchA[2] ?? 0);
                $versionB = (int)($matchB[1] ?? $matchB[2] ?? 0);
                return $versionB <=> $versionA; // Descending order
            });
            
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    Log::info('Using Java from detected path', ['path' => $path]);
                    return $path;
                }
            }
        }

        // Try to find java in PATH
        $javaCommand = PHP_OS_FAMILY === 'Windows' ? 'java.exe' : 'java';
        $whereCommand = PHP_OS_FAMILY === 'Windows' ? ['where', $javaCommand] : ['which', 'java'];
        $process = new Process($whereCommand);
        
        try {
            $process->run();
            if ($process->isSuccessful()) {
                $output = trim($process->getOutput());
                // On Windows, 'where' can return multiple paths, take the first one
                if (PHP_OS_FAMILY === 'Windows') {
                    $lines = explode("\n", $output);
                    $output = trim($lines[0] ?? '');
                }
                if (!empty($output) && file_exists($output)) {
                    Log::info('Using Java from PATH', ['path' => $output]);
                    return $output;
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to find Java in PATH', ['error' => $e->getMessage()]);
        }

        // Default fallback
        $defaultPath = PHP_OS_FAMILY === 'Windows' ? 'java.exe' : 'java';
        Log::warning('Using default Java path (may not work)', ['path' => $defaultPath]);
        return $defaultPath;
    }
}

