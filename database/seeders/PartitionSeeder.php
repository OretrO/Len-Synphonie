<?php

namespace Database\Seeders;

use App\Models\Partition;
use App\Models\User;
use Illuminate\Database\Seeder;

class PartitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer des utilisateurs qui peuvent créer des partitions
        $users = User::whereIn('role', ['admin', 'arranger', 'user'])->get();

        if ($users->isEmpty()) {
            $this->command->warn('Aucun utilisateur trouvé. Exécutez UserSeeder d\'abord.');
            return;
        }

        // Partitions classiques célèbres
        $classicalPartitions = [
            ['title' => 'Symphonie n°5', 'composer' => 'Ludwig van Beethoven'],
            ['title' => 'Les Quatre Saisons - Le Printemps', 'composer' => 'Antonio Vivaldi'],
            ['title' => 'Clair de Lune', 'composer' => 'Claude Debussy'],
            ['title' => 'Ave Maria', 'composer' => 'Franz Schubert'],
            ['title' => 'Canon en Ré majeur', 'composer' => 'Johann Pachelbel'],
            ['title' => 'La Marche Turque', 'composer' => 'Wolfgang Amadeus Mozart'],
            ['title' => 'Prélude en Do majeur', 'composer' => 'Johann Sebastian Bach'],
            ['title' => 'Boléro', 'composer' => 'Maurice Ravel'],
            ['title' => 'Gymnopédie n°1', 'composer' => 'Erik Satie'],
            ['title' => 'La Valse', 'composer' => 'Maurice Ravel'],
        ];

        foreach ($classicalPartitions as $partitionData) {
            Partition::factory()
                ->for($users->random())
                ->create([
                    'title' => $partitionData['title'],
                    'composer' => $partitionData['composer'],
                ]);
        }

        // Partitions supplémentaires avec compositeurs variés
        Partition::factory()
            ->count(10)
            ->create([
                'user_id' => fn() => $users->random()->id,
            ]);

        // Quelques partitions sans compositeur
        Partition::factory()
            ->withoutComposer()
            ->count(5)
            ->create([
                'user_id' => fn() => $users->random()->id,
            ]);
    }
}

