<?php
}
    }
        ]);
            'composer' => $composer,
        return $this->state(fn (array $attributes) => [
    {
    public function withComposer(string $composer): static
     */
     * Indicate that the partition has a specific composer.
    /**

    }
        ]);
            'composer' => null,
        return $this->state(fn (array $attributes) => [
    {
    public function withoutComposer(): static
     */
     * Indicate that the partition has no composer.
    /**

    }
        ];
            'user_id' => User::factory(),
            'musicxml_file_path' => 'partitions/' . fake()->uuid() . '.musicxml',
            'composer' => fake()->optional(0.8)->name(),
            'title' => fake()->sentence(3),
        return [
    {
    public function definition(): array
     */
     * @return array<string, mixed>
     *
     * Define the model's default state.
    /**

    protected $model = Partition::class;
     */
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     *
     * The name of the factory's corresponding model.
    /**
{
class PartitionFactory extends Factory
 */
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partition>
/**

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Partition;

namespace Database\Factories;


