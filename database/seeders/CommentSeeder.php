<?php

namespace Database\Seeders;

use App\Models\Arrangement;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $arrangements = Arrangement::all();

        if ($users->isEmpty() || $arrangements->isEmpty()) {
            $this->command->warn('Assurez-vous que UserSeeder et ArrangementSeeder ont été exécutés.');
            return;
        }

        // Commentaires prédéfinis réalistes
        $commentTemplates = [
            'Magnifique arrangement ! J\'adore la façon dont les instruments se mêlent.',
            'Belle interprétation, mais je pense que le tempo pourrait être un peu plus rapide.',
            'Excellent travail sur l\'orchestration !',
            'C\'est exactement ce que je cherchais, merci pour ce partage.',
            'Les cuivres sont un peu trop forts à mon goût.',
            'Superbe rendu, surtout au niveau des cordes.',
            'Très émotionnel, j\'ai été transporté.',
            'Bon arrangement, mais la balance entre les instruments pourrait être améliorée.',
            'Impressionnant ! Combien de temps avez-vous passé dessus ?',
            'J\'aime beaucoup cette version, très originale.',
        ];

        // Pour chaque arrangement, créer 0 à 8 commentaires
        foreach ($arrangements as $arrangement) {
            $commentCount = rand(0, 8);

            for ($i = 0; $i < $commentCount; $i++) {
                Comment::factory()
                    ->for($arrangement)
                    ->for($users->random())
                    ->create([
                        'content' => $commentTemplates[array_rand($commentTemplates)],
                    ]);
            }
        }

        // Créer quelques commentaires courts
        Comment::factory()
            ->short()
            ->count(15)
            ->create([
                'arrangement_id' => fn() => $arrangements->random()->id,
                'user_id' => fn() => $users->random()->id,
            ]);

        // Créer quelques commentaires longs
        Comment::factory()
            ->long()
            ->count(10)
            ->create([
                'arrangement_id' => fn() => $arrangements->random()->id,
                'user_id' => fn() => $users->random()->id,
            ]);
    }
}

