<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Partition;
use App\Models\Instrument;
use App\Models\Arrangement;
use App\Jobs\GenerateArrangementAudio;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MysterePartitionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🎼 Importation des partitions Mystère...');

        // Récupérer un utilisateur admin ou arranger pour être le créateur
        $creator = User::whereIn('role', ['admin', 'arranger'])->first();
        
        if (!$creator) {
            $this->command->error('❌ Aucun utilisateur admin ou arranger trouvé. Créez-en un d\'abord.');
            return;
        }

        // Chemin vers le dossier public/storage/partitions/xml
        $xmlSourceDir = public_path('storage/partitions/xml');
        
        if (!File::isDirectory($xmlSourceDir)) {
            $this->command->error("❌ Dossier non trouvé: {$xmlSourceDir}");
            $this->command->info("   Placez les fichiers XML dans ce dossier avant d'exécuter le seeder.");
            return;
        }

        // Liste des fichiers XML à importer
        $xmlFiles = [
            'mystere-1.xml',
            'mystere-2.xml',
            'mystere-4.xml',
            'mystere-5.xml',
            'mystere-6.xml',
        ];

        // Noms aléatoires pour les partitions
        $partitionNames = [
            'Symphonie Nocturne',
            'Rhapsodie Élégante',
            'Concerto Lunaire',
            'Sonate des Vents',
            'Prélude Mystérieux',
            'Ballade Céleste',
        ];

        // Compositeurs aléatoires
        $composers = [
            'Jean-Baptiste Lully',
            'Claude Debussy',
            'Maurice Ravel',
            'Camille Saint-Saëns',
            'Gabriel Fauré',
            'Erik Satie',
        ];

        // Genres
        $genres = ['Classique', 'Romantique', 'Moderne', 'Baroque', 'Impressionniste'];

        // Récupérer tous les instruments disponibles
        $allInstruments = Instrument::all();
        
        if ($allInstruments->isEmpty()) {
            $this->command->error('❌ Aucun instrument trouvé. Exécutez d\'abord le DatabaseSeeder.');
            return;
        }

        $partitionsCreated = 0;
        $arrangementsCreated = 0;

        foreach ($xmlFiles as $index => $xmlFile) {
            // Chemin vers le fichier dans public/storage/partitions/xml
            $sourcePath = public_path("storage/partitions/xml/{$xmlFile}");
            
            // Vérifier si le fichier source existe
            if (!File::exists($sourcePath)) {
                $this->command->warn("⚠️  Fichier non trouvé: {$xmlFile}");
                $this->command->info("   Chemin attendu: {$sourcePath}");
                continue;
            }

            // Le fichier est déjà dans le bon dossier, on utilise directement le chemin relatif
            // Format: partitions/xml/mystere-1.xml
            $destinationPath = "partitions/xml/{$xmlFile}";
            
            // Vérifier si le fichier existe déjà dans storage/app/public
            $storagePath = storage_path("app/public/{$destinationPath}");
            if (!File::exists($storagePath)) {
                // Copier le fichier vers storage/app/public/partitions/xml
                try {
                    Storage::disk('public')->put($destinationPath, File::get($sourcePath));
                    $this->command->info("✅ Fichier copié: {$xmlFile} → {$destinationPath}");
                } catch (\Exception $e) {
                    $this->command->error("❌ Erreur lors de la copie de {$xmlFile}: " . $e->getMessage());
                    continue;
                }
            } else {
                $this->command->info("ℹ️  Fichier déjà présent: {$destinationPath}");
            }

            // Créer la partition
            $partition = Partition::create([
                'title' => $partitionNames[$index] ?? "Partition Mystère " . ($index + 1),
                'composer' => $composers[$index] ?? 'Compositeur Inconnu',
                'genre' => $genres[array_rand($genres)],
                'description' => "Partition importée depuis {$xmlFile}. Une œuvre mystérieuse et envoûtante.",
                'musicxml_file_path' => $destinationPath,
                'musicpdf_file_path' => null, // Pas de PDF pour l'instant
                'user_id' => $creator->id,
            ]);

            $partitionsCreated++;
            $this->command->info("📝 Partition créée: {$partition->title} (ID: {$partition->id})");

            // Créer 2-3 arrangements pour cette partition
            $arrangementCount = rand(2, 3);
            
            for ($i = 0; $i < $arrangementCount; $i++) {
                // Sélectionner 2-4 instruments aléatoires
                $selectedInstruments = $allInstruments->random(rand(2, min(4, $allInstruments->count())));
                
                // Créer la configuration des instruments
                $instrumentsConfig = [];
                foreach ($selectedInstruments as $instrument) {
                    $instrumentsConfig[] = $instrument->id;
                }

                // Créer l'arrangement
                $arrangement = Arrangement::create([
                    'partition_id' => $partition->id,
                    'creator_id' => $creator->id,
                    'name' => "Arrangement " . ($i + 1) . " - " . $selectedInstruments->pluck('name')->join(', '),
                    'description' => "Arrangement avec " . $selectedInstruments->count() . " instrument(s): " . $selectedInstruments->pluck('name')->join(', '),
                    'instruments_config' => $instrumentsConfig,
                    'audio_file_path' => null,
                    'status' => 'pending',
                ]);

                // Attacher les instruments avec leur numéro de piste
                $sync = [];
                foreach ($selectedInstruments as $idx => $instrument) {
                    $sync[$instrument->id] = ['track_number' => $idx + 1];
                }
                $arrangement->instruments()->sync($sync);

                // Dispatch le job pour générer l'audio
                dispatch(new GenerateArrangementAudio($arrangement));

                $arrangementsCreated++;
                $this->command->info("  🎵 Arrangement créé: {$arrangement->name} (ID: {$arrangement->id})");
                $this->command->info("     ⏳ Job de génération audio dispatché");
            }
        }

        $this->command->info('');
        $this->command->info("✨ Seeder terminé avec succès!");
        $this->command->info("📊 Statistiques:");
        $this->command->info("   - Partitions créées: {$partitionsCreated}");
        $this->command->info("   - Arrangements créés: {$arrangementsCreated}");
        $this->command->info('');
        $this->command->info("💡 Pour générer les fichiers audio, lancez:");
        $this->command->info("   php artisan queue:work --queue=audio");
    }
}

