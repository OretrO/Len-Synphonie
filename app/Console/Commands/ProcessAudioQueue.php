<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Arrangement;
use App\Jobs\GenerateArrangementAudio;

class ProcessAudioQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:audio-worker {--once : Process only one job}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process audio generation queue for arrangements';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting audio queue processor...');

        if ($this->option('once')) {
            // Process one job and exit
            $this->call('queue:work', [
                '--queue' => 'audio',
                '--once' => true,
            ]);
        } else {
            // Start continuous queue worker
            $this->info('Processing audio queue continuously. Press Ctrl+C to stop.');
            $this->call('queue:work', [
                '--queue' => 'audio',
            ]);
        }

        return 0;
    }
}

