<?php

namespace Database\Factories;

use App\Models\Arrangement;
use App\Models\Partition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Arrangement>
 */
class ArrangementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Arrangement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $instruments = ['piano', 'violin', 'cello', 'flute', 'clarinet', 'trumpet', 'guitar', 'drums'];
        $selectedInstruments = fake()->randomElements($instruments, fake()->numberBetween(1, 4));

        $instrumentsConfig = [];
        foreach ($selectedInstruments as $instrument) {
            $instrumentsConfig[] = [
                'name' => $instrument,
                'volume' => fake()->numberBetween(50, 100),
                'pan' => fake()->numberBetween(-50, 50),
            ];
        }

        return [
            'partition_id' => Partition::factory(),
            'name' => fake()->words(3, true),
            'instruments_config' => $instrumentsConfig,
            'audio_file_path' => null,
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'failed']),
        ];
    }

    /**
     * Indicate that the arrangement is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'audio_file_path' => null,
        ]);
    }

    /**
     * Indicate that the arrangement is processing.
     */
    public function processing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'processing',
            'audio_file_path' => null,
        ]);
    }

    /**
     * Indicate that the arrangement is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'audio_file_path' => 'arrangements/' . fake()->uuid() . '.mp3',
        ]);
    }

    /**
     * Indicate that the arrangement has failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'audio_file_path' => null,
        ]);
    }
}

