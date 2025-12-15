<?php

namespace Database\Seeders;

use App\Models\Arrangement;
use App\Models\User;
use App\Models\UserArrangement;
use Illuminate\Database\Seeder;

class UserArrangementSeeder extends Seeder
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

        // Pour chaque arrangement, créer des associations avec plusieurs utilisateurs
        foreach ($arrangements as $arrangement) {
            // Chaque arrangement est associé à 3-8 utilisateurs aléatoires
            $selectedUsers = $users->random(rand(3, min(8, $users->count())));

            foreach ($selectedUsers as $user) {
                // Vérifier si l'association existe déjà
                $exists = UserArrangement::where('user_id', $user->id)
                    ->where('arrangement_id', $arrangement->id)
                    ->exists();

                if (!$exists) {
                    UserArrangement::factory()
                        ->for($user)
                        ->for($arrangement)
                        ->create();
                }
            }
        }

        // Créer également quelques associations supplémentaires aléatoires
        UserArrangement::factory()
            ->count(20)
            ->create();
    }
}

