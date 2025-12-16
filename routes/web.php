<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartitionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ArrangementController;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// Routes d'inscription
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Routes de reset de mot de passe
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Routes de connexion
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes des partitions (accessibles à tous - visitor peut voir la liste)
Route::get('/partitions', [PartitionController::class, 'index'])->name('partitions.index');
// Route de recherche publique pour les partitions
Route::get('/partitions/search', [PartitionController::class, 'Search'])->name('partitions.search');

// Routes publiques pour les fichiers audio - DOIT ÊTRE AVANT LES AUTRES ROUTES
// Route pour streamer/jouer les fichiers audio
Route::get('/audio/{arrangementId}/{filename}', function ($arrangementId, $filename) {
        // Sanitize filename to prevent directory traversal
        $filename = basename($filename);
        $arrangementId = (int) $arrangementId;
        
        $path = storage_path("app/public/arrangements/{$arrangementId}/{$filename}");

        if (!file_exists($path)) {
            \Log::warning('Audio file not found', [
                'path' => $path,
                'arrangement_id' => $arrangementId,
                'filename' => $filename
            ]);
            abort(404, "Audio file not found: {$filename}");
        }

        $fileSize = filesize($path);
        $file = fopen($path, 'rb');
        
        // Support for Range Requests (required for audio streaming)
        $range = request()->header('Range');
        
        if ($range) {
            // Parse range header
            preg_match('/bytes=(\d+)-(\d*)/', $range, $matches);
            $start = (int) $matches[1];
            $end = $matches[2] ? (int) $matches[2] : $fileSize - 1;
            $length = $end - $start + 1;
            
            // Set partial content headers
            fseek($file, $start);
            $data = fread($file, $length);
            fclose($file);
            
            return response($data, 206, [
                'Content-Type' => 'audio/wav',
                'Content-Length' => $length,
                'Content-Range' => "bytes {$start}-{$end}/{$fileSize}",
                'Accept-Ranges' => 'bytes',
                'Cache-Control' => 'public, max-age=3600',
            ]);
        }
        
        // Full file response
        fclose($file);
        
        return response()->file($path, [
            'Content-Type' => 'audio/wav',
            'Content-Length' => $fileSize,
            'Accept-Ranges' => 'bytes',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Cache-Control' => 'public, max-age=3600',
        ]);
})->name('audio.stream');

// Route pour télécharger les fichiers audio
Route::get('/download/audio/{arrangementId}/{filename}', function ($arrangementId, $filename) {
        // Sanitize filename to prevent directory traversal
        $filename = basename($filename);
        $arrangementId = (int) $arrangementId;
        
        $path = storage_path("app/public/arrangements/{$arrangementId}/{$filename}");

        if (!file_exists($path)) {
            \Log::warning('Audio file not found for download', [
                'path' => $path,
                'arrangement_id' => $arrangementId,
                'filename' => $filename
            ]);
            abort(404, "Audio file not found: {$filename}");
        }

        return response()->download($path, $filename, [
            'Content-Type' => 'audio/wav',
        ]);
})->name('audio.download');

// Routes nécessitant une authentification (user, arranger, admin)
Route::middleware('auth')->group(function () {

    // --- 1. ROUTES SPÉCIFIQUES (DOIVENT ÊTRE EN PREMIER) ---

    // Création (Avant le show !)
    Route::get('/partitions/create', [PartitionController::class, 'create'])->name('partitions.create');
    Route::post('/partitions', [PartitionController::class, 'store'])->name('partitions.store');

    // Fichiers de partition (PDF/XML)
    Route::get('/partitions/{partition}/file', [PartitionController::class, 'downloadFile'])->name('partitions.file');

    // --- 2. ROUTES AVEC VARIABLES (WILDCARDS) ---

    // Détails d'une partition (Celle-ci "mange" tout ce qui suit /partitions/...)
    Route::get('/partitions/{partition}', [PartitionController::class, 'show'])->name('partitions.show');

    // Modification et Suppression
    Route::get('/partitions/{partition}/edit', [PartitionController::class, 'edit'])->name('partitions.edit');
    Route::put('/partitions/{partition}', [PartitionController::class, 'update'])->name('partitions.update');
    Route::delete('/partitions/{partition}', [PartitionController::class, 'destroy'])->name('partitions.destroy');

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('arrangements', ArrangementController::class)->only([
        'index', 'show', 'create', 'store', 'edit', 'update', 'destroy',
    ]);
});
