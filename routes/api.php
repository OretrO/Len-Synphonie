<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArrangementController;

// API Routes pour les arrangements
Route::apiResource('arrangements', ArrangementController::class)->only(['index', 'show']);

// Route pour obtenir le statut de génération audio d'un arrangement
Route::get('/arrangements/{arrangement}/audio-status', function (\App\Models\Arrangement $arrangement) {
    return response()->json([
        'id' => $arrangement->id,
        'name' => $arrangement->name,
        'status' => $arrangement->status,
        'audio_file_path' => $arrangement->audio_file_path,
        'audio_generation_error' => $arrangement->audio_generation_error,
        'created_at' => $arrangement->created_at,
        'updated_at' => $arrangement->updated_at,
    ]);
})->name('arrangements.audio-status');

