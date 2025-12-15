<?php

namespace Database\Seeders;

use App\Models\Instrument;
use Illuminate\Database\Seeder;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instruments = [
            ['name' => 'Piano', 'category' => 'Keyboard', 'soundfont_file_path' => 'soundfonts/piano.sf2'],
            ['name' => 'Grand Piano', 'category' => 'Keyboard', 'soundfont_file_path' => 'soundfonts/grand_piano.sf2'],
            ['name' => 'Violin', 'category' => 'Strings', 'soundfont_file_path' => 'soundfonts/violin.sf2'],
            ['name' => 'Cello', 'category' => 'Strings', 'soundfont_file_path' => 'soundfonts/cello.sf2'],
            ['name' => 'Viola', 'category' => 'Strings', 'soundfont_file_path' => 'soundfonts/viola.sf2'],
            ['name' => 'Contrabass', 'category' => 'Strings', 'soundfont_file_path' => 'soundfonts/contrabass.sf2'],
            ['name' => 'Acoustic Guitar', 'category' => 'Strings', 'soundfont_file_path' => 'soundfonts/acoustic_guitar.sf2'],
            ['name' => 'Electric Guitar', 'category' => 'Strings', 'soundfont_file_path' => 'soundfonts/electric_guitar.sf2'],
            ['name' => 'Bass Guitar', 'category' => 'Strings', 'soundfont_file_path' => 'soundfonts/bass_guitar.sf2'],
            ['name' => 'Flute', 'category' => 'Woodwind', 'soundfont_file_path' => 'soundfonts/flute.sf2'],
            ['name' => 'Clarinet', 'category' => 'Woodwind', 'soundfont_file_path' => 'soundfonts/clarinet.sf2'],
            ['name' => 'Oboe', 'category' => 'Woodwind', 'soundfont_file_path' => 'soundfonts/oboe.sf2'],
            ['name' => 'Bassoon', 'category' => 'Woodwind', 'soundfont_file_path' => 'soundfonts/bassoon.sf2'],
            ['name' => 'Saxophone', 'category' => 'Woodwind', 'soundfont_file_path' => 'soundfonts/saxophone.sf2'],
            ['name' => 'Trumpet', 'category' => 'Brass', 'soundfont_file_path' => 'soundfonts/trumpet.sf2'],
            ['name' => 'Trombone', 'category' => 'Brass', 'soundfont_file_path' => 'soundfonts/trombone.sf2'],
            ['name' => 'French Horn', 'category' => 'Brass', 'soundfont_file_path' => 'soundfonts/french_horn.sf2'],
            ['name' => 'Tuba', 'category' => 'Brass', 'soundfont_file_path' => 'soundfonts/tuba.sf2'],
            ['name' => 'Drums', 'category' => 'Percussion', 'soundfont_file_path' => 'soundfonts/drums.sf2'],
            ['name' => 'Timpani', 'category' => 'Percussion', 'soundfont_file_path' => 'soundfonts/timpani.sf2'],
            ['name' => 'Xylophone', 'category' => 'Percussion', 'soundfont_file_path' => 'soundfonts/xylophone.sf2'],
            ['name' => 'Harp', 'category' => 'Strings', 'soundfont_file_path' => 'soundfonts/harp.sf2'],
            ['name' => 'Organ', 'category' => 'Keyboard', 'soundfont_file_path' => 'soundfonts/organ.sf2'],
        ];

        foreach ($instruments as $instrument) {
            Instrument::create($instrument);
        }
    }
}

