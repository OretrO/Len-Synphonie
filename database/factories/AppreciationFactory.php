<?php

namespace Database\Factories;

use App\Models\UserArrangement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appreciation>
 */
class AppreciationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_like' => fake()->boolean(70), // 70% de chance d'être un like
            // user_id and like_id (arrangement) will be set in the seeder
        ];
    }

    /**
     * Indicate that this is a like.
     */
    public function like(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_like' => true,
        ]);
    }

    /**
     * Indicate that this is a dislike.
     */
    public function dislike(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_like' => false,
        ]);
    }
}

