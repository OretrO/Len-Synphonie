<?php

namespace Database\Seeders;

+use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🎵 Démarrage du seeding de LenSymphony...');

        // L'ordre est important pour respecter les contraintes de clés étrangères
        $this->call([
            UserSeeder::class,
            InstrumentSeeder::class,
            PartitionSeeder::class,
            ArrangementSeeder::class,
            UserArrangementSeeder::class,
            AppreciationSeeder::class,
            CommentSeeder::class,
        ]);

        $this->command->info('✅ Seeding terminé avec succès !');
        $this->command->info('');
        $this->command->info('📊 Résumé des données générées :');
        $this->command->table(
            ['Table', 'Nombre d\'enregistrements'],
            [
                ['Users', \App\Models\User::count()],
                ['Instruments', \App\Models\Instrument::count()],
                ['Partitions', \App\Models\Partition::count()],
                ['Arrangements', \App\Models\Arrangement::count()],
                ['User Arrangements', \App\Models\UserArrangement::count()],
                ['Appreciations', \App\Models\Appreciation::count()],
                ['Comments', \App\Models\Comment::count()],
            ]
        );
    }
}
