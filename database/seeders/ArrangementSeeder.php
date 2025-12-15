<?php

namespace Database\Seeders;

use App\Models\Arrangement;
use App\Models\Instrument;
use App\Models\Partition;
use Illuminate\Database\Seeder;

class ArrangementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partitions = Partition::all();
        $instruments = Instrument::all();

        if ($partitions->isEmpty()) {
            $this->command->warn('Aucune partition trouvée. Exécutez PartitionSeeder d\'abord.');
            return;
        }

        if ($instruments->isEmpty()) {
            $this->command->warn('Aucun instrument trouvé. Exécutez InstrumentSeeder d\'abord.');
            return;
        }

        foreach ($partitions as $partition) {
            // Créer 1 à 3 arrangements par partition
            $arrangementCount = rand(1, 3);

            for ($i = 0; $i < $arrangementCount; $i++) {
                // Créer l'arrangement
                $arrangement = Arrangement::factory()
                    ->for($partition)
                    ->create();

                // Attacher 2 à 6 instruments aléatoires
                $selectedInstruments = $instruments->random(rand(2, 6));

                foreach ($selectedInstruments as $index => $instrument) {
                    $arrangement->instruments()->attach($instrument->id, [
                        'track_number' => $index + 1,
                    ]);
                }
            }
        }

        // Créer quelques arrangements avec des statuts spécifiques
        $partition = $partitions->random();

        // Arrangement en attente
        $pendingArrangement = Arrangement::factory()
            ->for($partition)
            ->pending()
            ->create();
        $pendingArrangement->instruments()->attach(
            $instruments->random(3)->pluck('id'),
            fn($index) => ['track_number' => $index + 1]
        );

        // Arrangement en cours de traitement
        $processingArrangement = Arrangement::factory()
            ->for($partition)
            ->processing()
            ->create();
        $processingArrangement->instruments()->attach(
            $instruments->random(4)->pluck('id'),
            fn($index) => ['track_number' => $index + 1]
        );

        // Arrangement échoué
        $failedArrangement = Arrangement::factory()
            ->for($partition)
            ->failed()
            ->create();
        $failedArrangement->instruments()->attach(
            $instruments->random(2)->pluck('id'),
            fn($index) => ['track_number' => $index + 1]
        );
    }
}

