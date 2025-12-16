<?php

namespace App\Console\Commands;

use App\Jobs\GenerateArrangementAudio;
use App\Models\Arrangement;
use Illuminate\Console\Command;
use ReflectionClass;

class TestJavaDetection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'java:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Java detection for LenSymphony audio generation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Java detection...');
        $this->newLine();

        // Get an arrangement (or create a dummy one)
        $arrangement = Arrangement::first();
        
        if (!$arrangement) {
            $this->warn('No arrangement found. Creating a test arrangement...');
            // We can't create a full arrangement without a partition, so just test the method directly
            $this->testJavaPathDirectly();
            return 0;
        }

        try {
            $job = new GenerateArrangementAudio($arrangement);
            $reflection = new ReflectionClass($job);
            $method = $reflection->getMethod('getJavaPath');
            $method->setAccessible(true);
            
            $javaPath = $method->invoke($job);
            
            $this->info('✅ Java detected successfully!');
            $this->line("Java path: <fg=cyan>{$javaPath}</>");
            $this->newLine();

            // Verify the path exists
            if (file_exists($javaPath)) {
                $this->info('✅ Java executable exists at this path');
            } else {
                $this->warn('⚠️  Java executable not found at this path (may still work if in PATH)');
            }

            // Try to get Java version
            $this->info('Checking Java version...');
            $process = new \Symfony\Component\Process\Process([$javaPath, '-version']);
            $process->run();
            
            if ($process->isSuccessful()) {
                $output = $process->getErrorOutput(); // Java version goes to stderr
                $this->line("<fg=gray>{$output}</>");
            } else {
                $this->warn('Could not get Java version');
            }

            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Error testing Java detection:');
            $this->error($e->getMessage());
            return 1;
        }
    }

    private function testJavaPathDirectly()
    {
        // Create a minimal job instance to test
        $arrangement = new Arrangement();
        $arrangement->id = 1;
        
        try {
            $job = new GenerateArrangementAudio($arrangement);
            $reflection = new ReflectionClass($job);
            $method = $reflection->getMethod('getJavaPath');
            $method->setAccessible(true);
            
            $javaPath = $method->invoke($job);
            
            $this->info('✅ Java detected successfully!');
            $this->line("Java path: <fg=cyan>{$javaPath}</>");
            
            if (file_exists($javaPath)) {
                $this->info('✅ Java executable exists at this path');
            } else {
                $this->warn('⚠️  Java executable not found at this path');
            }
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
        }
    }
}
