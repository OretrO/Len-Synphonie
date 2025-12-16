<?php

namespace App\Console\Commands;

use App\Models\Arrangement;
use App\Jobs\GenerateArrangementAudio;
use Illuminate\Console\Command;

class DispatchAudioJobs extends Command
{
    protected $signature = 'audio:dispatch {--all : Dispatch for all pending arrangements}';
    protected $description = 'Dispatch audio generation jobs for pending arrangements';

    public function handle()
    {
        if ($this->option('all')) {
            $arrangements = Arrangement::where('status', 'pending')
                ->orWhere('status', 'processing')
                ->get();
        } else {
            // Par défaut, seulement ceux créés récemment (dernières 24h)
            $arrangements = Arrangement::where('status', 'pending')
                ->where('created_at', '>=', now()->subDay())
                ->get();
        }

        if ($arrangements->isEmpty()) {
            $this->info('Aucun arrangement en attente trouvé.');
            return 0;
        }

        $this->info("Trouvé {$arrangements->count()} arrangement(s) en attente.");

        $dispatched = 0;
        foreach ($arrangements as $arrangement) {
            // Vérifier que la partition a un fichier MusicXML
            if (!$arrangement->partition || !$arrangement->partition->musicxml_file_path) {
                $this->warn("Arrangement {$arrangement->id}: Partition ou fichier MusicXML manquant");
                continue;
            }

            // Vérifier que l'arrangement a des instruments
            if ($arrangement->instruments->isEmpty()) {
                $this->warn("Arrangement {$arrangement->id}: Aucun instrument associé");
                continue;
            }

            // Dispatcher le job
            dispatch(new GenerateArrangementAudio($arrangement));
            $dispatched++;

            $this->info("✅ Job dispatché pour l'arrangement {$arrangement->id}: {$arrangement->name}");
        }

        $this->info("");
        $this->info("✨ {$dispatched} job(s) dispatché(s) avec succès!");
        $this->info("");
        $this->info("💡 Lancez maintenant: php artisan queue:work --queue=audio");

        return 0;
    }
}

