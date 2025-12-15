<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instrument>
 */
class InstrumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $instruments = [
            ['name' => 'Piano', 'category' => 'Keyboard'],
            ['name' => 'Violin', 'category' => 'Strings'],
            ['name' => 'Cello', 'category' => 'Strings'],
            ['name' => 'Flute', 'category' => 'Woodwind'],
            ['name' => 'Clarinet', 'category' => 'Woodwind'],
            ['name' => 'Trumpet', 'category' => 'Brass'],
            ['name' => 'Trombone', 'category' => 'Brass'],
            ['name' => 'Guitar', 'category' => 'Strings'],
            ['name' => 'Bass', 'category' => 'Strings'],
            ['name' => 'Drums', 'category' => 'Percussion'],
            ['name' => 'Saxophone', 'category' => 'Woodwind'],
            ['name' => 'Harp', 'category' => 'Strings'],
        ];

        $instrument = fake()->randomElement($instruments);

        return [
            'name' => $instrument['name'],
            'category' => $instrument['category'],
            'soundfont_file_path' => 'soundfonts/' . strtolower($instrument['name']) . '.sf2',
        ];
    }

    /**
     * Indicate that the instrument is a piano.
     */
    public function piano(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Piano',
            'category' => 'Keyboard',
            'soundfont_file_path' => 'soundfonts/piano.sf2',
        ]);
    }

    /**
     * Indicate that the instrument is a violin.
     */
    public function violin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Violin',
            'category' => 'Strings',
            'soundfont_file_path' => 'soundfonts/violin.sf2',
        ]);
    }

    /**
     * Indicate that the instrument is a guitar.
     */
    public function guitar(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Guitar',
            'category' => 'Strings',
            'soundfont_file_path' => 'soundfonts/guitar.sf2',
        ]);
    }
}
