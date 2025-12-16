<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Partition;
use App\Models\Instrument;
use App\Models\Arrangement;
use App\Models\Comment;
use App\Models\Appreciation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Création des utilisateurs avec différents rôles

        // UTILISATEURS DE TEST (credentials connus pour tester les rôles)
        $admin = User::factory()->admin()->create([
            'name' => 'Robert Manitou',
            'email' => 'Robert.Manitou@domain.fr',
            'password' => bcrypt('GrosSecret25'), // Mot de passe : password
        ]);

        $arranger = User::factory()->arranger()->create([
            'name' => 'Gerard Getta',
            'email' => 'Gerard.Getta@domain.fr',
            'password' => bcrypt('GrosSecret25'), // Mot de passe : password
        ]);

        $user = User::factory()->user()->create([
            'name' => 'Jean Lepetit',
            'email' => 'Jean.Lepetit@domain.fr',
            'password' => bcrypt('GrosSecret25'), // Mot de passe : password
        ]);


        // Autres utilisateurs aléatoires
        $arrangers = User::factory()->arranger()->count(4)->create();
        $users = User::factory()->user()->count(14)->create();
        $visitors = User::factory()->visitor()->count(4)->create();

        $allUsers = User::all();

        // 2. Création des instruments
        $instruments = [
            ['name' => 'Piano', 'category' => 'Keyboard', 'soundfont_file_path' => 'soundfonts/piano.sf2'],
            ['name' => 'Violin', 'category' => 'Strings', 'soundfont_file_path' => 'soundfonts/violin.sf2'],
            ['name' => 'Cello', 'category' => 'Strings', 'soundfont_file_path' => 'soundfonts/cello.sf2'],
            ['name' => 'Flute', 'category' => 'Woodwind', 'soundfont_file_path' => 'soundfonts/flute.sf2'],
            ['name' => 'Clarinet', 'category' => 'Woodwind', 'soundfont_file_path' => 'soundfonts/clarinet.sf2'],
            ['name' => 'Trumpet', 'category' => 'Brass', 'soundfont_file_path' => 'soundfonts/trumpet.sf2'],
            ['name' => 'Guitar', 'category' => 'Strings', 'soundfont_file_path' => 'soundfonts/guitar.sf2'],
            ['name' => 'Drums', 'category' => 'Percussion', 'soundfont_file_path' => 'soundfonts/drums.sf2'],
        ];

        foreach ($instruments as $instrumentData) {
            Instrument::create($instrumentData);
        }

        $allInstruments = Instrument::all();

        // 3. Création des partitions (créées par les arrangers et l'admin)
        $creators = collect([$admin, $arranger])->concat($arrangers);
        $partitions = collect();

        foreach ($creators as $creator) {
            $userPartitions = Partition::factory()->count(rand(2, 5))->create([
                'user_id' => $creator->id,
            ]);
            $partitions = $partitions->concat($userPartitions);
        }

        // 4. Création des arrangements pour chaque partition
        foreach ($partitions as $partition) {
            $arrangementCount = rand(1, 3);

            for ($i = 0; $i < $arrangementCount; $i++) {
                // Configuration des instruments pour l'arrangement
                $selectedInstruments = $allInstruments->random(rand(2, 4));
                $instrumentsConfig = [];

                foreach ($selectedInstruments as $instrument) {
                    $instrumentsConfig[] = [
                        'name' => $instrument->name,
                        'volume' => rand(50, 100),
                        'pan' => rand(-50, 50),
                    ];
                }

                $arrangement = Arrangement::factory()->create([
                    'partition_id' => $partition->id,
                    'creator_id' => $partition->user_id, // Le créateur de la partition crée l'arrangement
                    'instruments_config' => $instrumentsConfig,
                ]);

                // 5. Créer la relation ArrangementInstruments (table pivot)
                foreach ($selectedInstruments as $index => $instrument) {
                    $arrangement->instruments()->attach($instrument->id, [
                        'track_number' => $index + 1,
                    ]);
                }

                // 6. Créer des commentaires sur cet arrangement
                $commentCount = rand(2, 6);
                $commentUsers = $allUsers->random(min($commentCount, $allUsers->count()));

                foreach ($commentUsers as $commentUser) {
                    Comment::factory()->create([
                        'arrangement_id' => $arrangement->id,
                        'user_id' => $commentUser->id,
                    ]);
                }

                // 7. Créer des appréciations (likes/dislikes) sur cet arrangement
                $appreciationUsers = $allUsers->random(rand(5, 15));

                foreach ($appreciationUsers as $appreciationUser) {
                    // Éviter les doublons (unique constraint sur user_id + arrangement_id)
                    if (!Appreciation::where('user_id', $appreciationUser->id)
                        ->where('arrangement_id', $arrangement->id)->exists()) {

                        Appreciation::factory()->create([
                            'user_id' => $appreciationUser->id,
                            'arrangement_id' => $arrangement->id,
                        ]);
                    }
                }
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Users created: ' . User::count());
        $this->command->info('  - Admins: ' . User::where('role', 'admin')->count());
        $this->command->info('  - Arrangers: ' . User::where('role', 'arranger')->count());
        $this->command->info('  - Users: ' . User::where('role', 'user')->count());
        $this->command->info('  - Visitors: ' . User::where('role', 'visitor')->count());
        $this->command->info('Partitions created: ' . Partition::count());
        $this->command->info('Arrangements created: ' . Arrangement::count());
        $this->command->info('Comments created: ' . Comment::count());
        $this->command->info('Appreciations created: ' . Appreciation::count());
    }
}

