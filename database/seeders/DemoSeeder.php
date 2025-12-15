<?php

namespace Database\Seeders;

use App\Models\Appreciation;
use App\Models\Arrangement;
use App\Models\Comment;
use App\Models\Instrument;
use App\Models\Partition;
use App\Models\User;
use App\Models\UserArrangement;
use Illuminate\Database\Seeder;

/**
 * Seeder pour créer un scénario de démonstration complet
 * avec des données cohérentes et faciles à suivre
 */
class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎭 Création du scénario de démonstration...');

        // 1. Créer des utilisateurs de démonstration
        $admin = User::factory()->admin()->create([
            'name' => 'Alice Admin',
            'email' => 'alice@lensymphony.com',
        ]);

        $arranger1 = User::factory()->arranger()->create([
            'name' => 'Bob Beethoven',
            'email' => 'bob@lensymphony.com',
        ]);

        $arranger2 = User::factory()->arranger()->create([
            'name' => 'Clara Mozart',
            'email' => 'clara@lensymphony.com',
        ]);

        $user1 = User::factory()->regularUser()->create([
            'name' => 'David Debussy',
            'email' => 'david@lensymphony.com',
        ]);

        $user2 = User::factory()->regularUser()->create([
            'name' => 'Emma Bach',
            'email' => 'emma@lensymphony.com',
        ]);

        $this->command->info('✓ 5 utilisateurs de démo créés');

        // 2. Créer quelques instruments essentiels
        $piano = Instrument::create([
            'name' => 'Piano',
            'category' => 'Keyboard',
            'soundfont_file_path' => 'soundfonts/piano.sf2',
        ]);

        $violin = Instrument::create([
            'name' => 'Violin',
            'category' => 'Strings',
            'soundfont_file_path' => 'soundfonts/violin.sf2',
        ]);

        $cello = Instrument::create([
            'name' => 'Cello',
            'category' => 'Strings',
            'soundfont_file_path' => 'soundfonts/cello.sf2',
        ]);

        $flute = Instrument::create([
            'name' => 'Flute',
            'category' => 'Woodwind',
            'soundfont_file_path' => 'soundfonts/flute.sf2',
        ]);

        $this->command->info('✓ 4 instruments créés');

        // 3. Créer des partitions célèbres
        $partition1 = Partition::factory()->create([
            'title' => 'Clair de Lune',
            'composer' => 'Claude Debussy',
            'user_id' => $arranger1->id,
        ]);

        $partition2 = Partition::factory()->create([
            'title' => 'Für Elise',
            'composer' => 'Ludwig van Beethoven',
            'user_id' => $arranger2->id,
        ]);

        $partition3 = Partition::factory()->create([
            'title' => 'Canon en Ré majeur',
            'composer' => 'Johann Pachelbel',
            'user_id' => $admin->id,
        ]);

        $this->command->info('✓ 3 partitions créées');

        // 4. Créer des arrangements variés

        // Arrangement 1 : Clair de Lune au piano (complété)
        $arrangement1 = Arrangement::factory()->completed()->create([
            'partition_id' => $partition1->id,
            'name' => 'Version Piano Solo',
        ]);
        $arrangement1->instruments()->attach($piano->id, ['track_number' => 1]);

        // Arrangement 2 : Clair de Lune version orchestrale (complété)
        $arrangement2 = Arrangement::factory()->completed()->create([
            'partition_id' => $partition1->id,
            'name' => 'Version Orchestrale',
        ]);
        $arrangement2->instruments()->attach([
            $piano->id => ['track_number' => 1],
            $violin->id => ['track_number' => 2],
            $cello->id => ['track_number' => 3],
        ]);

        // Arrangement 3 : Für Elise (en cours de traitement)
        $arrangement3 = Arrangement::factory()->processing()->create([
            'partition_id' => $partition2->id,
            'name' => 'Version Moderne',
        ]);
        $arrangement3->instruments()->attach([
            $piano->id => ['track_number' => 1],
            $flute->id => ['track_number' => 2],
        ]);

        // Arrangement 4 : Canon (en attente)
        $arrangement4 = Arrangement::factory()->pending()->create([
            'partition_id' => $partition3->id,
            'name' => 'Version Quatuor',
        ]);
        $arrangement4->instruments()->attach([
            $violin->id => ['track_number' => 1],
            $cello->id => ['track_number' => 2],
        ]);

        $this->command->info('✓ 4 arrangements créés');

        // 5. Créer des associations user-arrangement
        $ua1 = UserArrangement::create([
            'user_id' => $user1->id,
            'arrangement_id' => $arrangement1->id,
        ]);
        Appreciation::create([
            'user_arrangement_id' => $ua1->id,
            'is_like' => true,
        ]);

        $ua2 = UserArrangement::create([
            'user_id' => $user2->id,
            'arrangement_id' => $arrangement1->id,
        ]);
        Appreciation::create([
            'user_arrangement_id' => $ua2->id,
            'is_like' => true,
        ]);

        $ua3 = UserArrangement::create([
            'user_id' => $user1->id,
            'arrangement_id' => $arrangement2->id,
        ]);
        Appreciation::create([
            'user_arrangement_id' => $ua3->id,
            'is_like' => true,
        ]);

        $ua4 = UserArrangement::create([
            'user_id' => $admin->id,
            'arrangement_id' => $arrangement2->id,
        ]);
        Appreciation::create([
            'user_arrangement_id' => $ua4->id,
            'is_like' => false,
        ]);

        $this->command->info('✓ Associations et appréciations créées');

        // 6. Créer des commentaires significatifs
        Comment::create([
            'arrangement_id' => $arrangement1->id,
            'user_id' => $user1->id,
            'content' => 'Superbe rendu au piano ! L\'interprétation est très fidèle à l\'original.',
        ]);

        Comment::create([
            'arrangement_id' => $arrangement1->id,
            'user_id' => $user2->id,
            'content' => 'J\'adore cette version, parfaite pour s\'endormir !',
        ]);

        Comment::create([
            'arrangement_id' => $arrangement2->id,
            'user_id' => $user1->id,
            'content' => 'La version orchestrale est magnifique ! Les cordes apportent vraiment une dimension supplémentaire.',
        ]);

        Comment::create([
            'arrangement_id' => $arrangement2->id,
            'user_id' => $admin->id,
            'content' => 'Intéressant, mais je trouve que le violoncelle domine un peu trop. Peut-être ajuster le volume ?',
        ]);

        $this->command->info('✓ 4 commentaires créés');

        $this->command->info('');
        $this->command->info('✅ Scénario de démonstration créé avec succès !');
        $this->command->info('');
        $this->command->info('👥 Comptes de test :');
        $this->command->info('   - alice@lensymphony.com (Admin)');
        $this->command->info('   - bob@lensymphony.com (Arranger)');
        $this->command->info('   - clara@lensymphony.com (Arranger)');
        $this->command->info('   - david@lensymphony.com (User)');
        $this->command->info('   - emma@lensymphony.com (User)');
        $this->command->info('   Mot de passe pour tous : password');
    }
}
