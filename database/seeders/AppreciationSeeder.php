<?php

namespace Database\Seeders;

use App\Models\Appreciation;
use App\Models\UserArrangement;
use Illuminate\Database\Seeder;

class AppreciationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userArrangements = UserArrangement::all();

        if ($userArrangements->isEmpty()) {
            $this->command->warn('Aucune association user-arrangement trouvée. Exécutez UserArrangementSeeder d\'abord.');
            return;
        }

        // 70% des user_arrangements ont une appreciation
        $userArrangementsToAppreciate = $userArrangements->random(
            (int) ($userArrangements->count() * 0.7)
        );

        foreach ($userArrangementsToAppreciate as $userArrangement) {
            // 80% sont des likes, 20% des dislikes
            $isLike = rand(1, 100) <= 80;

            Appreciation::factory()
                ->for($userArrangement)
                ->create([
                    'is_like' => $isLike,
                ]);
        }
    }
}

