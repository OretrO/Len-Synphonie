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
            Storage::disk('public')->makeDirectory('audio/arrangements', 0755, true);

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
        $command = [
            '/usr/lib/jvm/java-25-openjdk/bin/java',
            '-jar',
            base_path('java/lensymphony.jar'),
            '-i',
            $musicXmlPath,
            '-o',
            $outputPath,
        ];

        // Add voice mappings: -v 1:SAXOPHONE -v 2:HORN etc.
        // Instruments are passed in order with 1-based indices
        if ($this->arrangement->instruments->count() > 0) {
            $trackNumber = 1;
            foreach ($this->arrangement->instruments as $instrument) {
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
}

