<?php

namespace App\Console\Commands;

use App\Models\Arrangement;
use Illuminate\Console\Command;

class CheckArrangementStatus extends Command
{
    protected $signature = 'arrangement:check {id?}';
    protected $description = 'Check arrangement status and audio file';

    public function handle()
    {
        $id = $this->argument('id');
        
        if ($id) {
            $arrangement = Arrangement::find($id);
        } else {
            $arrangement = Arrangement::latest()->first();
        }
        
        if (!$arrangement) {
            $this->error('No arrangement found');
            return 1;
        }
        
        $this->info("Arrangement ID: {$arrangement->id}");
        $this->info("Name: {$arrangement->name}");
        $this->info("Status: {$arrangement->status}");
        $this->info("Audio path: " . ($arrangement->audio_file_path ?? 'null'));
        $this->info("Error: " . ($arrangement->audio_generation_error ?? 'null'));
        
        if ($arrangement->audio_file_path) {
            $fullPath = storage_path('app/public/' . $arrangement->audio_file_path);
            $this->info("Full path: {$fullPath}");
            $this->info("File exists: " . (file_exists($fullPath) ? 'YES' : 'NO'));
        }
        
        return 0;
    }
}

