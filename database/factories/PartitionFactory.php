<?php

namespace Database\Factories;

use App\Models\Partition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partition>
 */
class PartitionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Partition::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),

            'composer' => fake()->optional(0.8)->name(),
            'musicxml_file_path' => 'partitions/' . fake()->uuid() . '.musicxml',
            'musicpdf_file_path' => fake()->optional(0.5, null)->randomElement([
                'partitions/' . fake()->uuid() . '.pdf',
                null,
            ]),
            'genre' => fake()->randomElement(['Pop', 'Blues', 'Rap', 'Rock', 'classique']),
            // user_id will be set in the seeder
        ];
    }

    /**
     * Indicate that the partition has no composer.
     */
    public function withoutComposer(): static
    {
        return $this->state(fn (array $attributes) => [
            'composer' => null,
        ]);
    }

    /**
     * Indicate that the partition has a specific composer.
     */
    public function withComposer(string $composer): static
    {
        return $this->state(fn (array $attributes) => [
            'composer' => $composer,
        ]);
    }
}
