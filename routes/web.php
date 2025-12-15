<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartitionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PartitionController;
use App\Http\Controllers\ArrangementController;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// Routes d'inscription
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Routes de connexion temporaires
Route::get('/login', function () {
    return redirect()->route('home');
})->name('login');

// Routes Partitions
Route::resource('partitions', PartitionController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::resource('partitions', PartitionController::class)->only([
        'create', 'store', 'edit', 'update', 'destroy',
    ]);

    Route::resource('arrangements', ArrangementController::class)->only([
        'index', 'show', 'create', 'store', 'edit', 'update', 'destroy',
    ]);
});

// Routes des partitions (accessibles à tous - visitor peut voir la liste)
Route::get('/partitions', [PartitionController::class, 'index'])->name('partitions.index');

// Routes nécessitant une authentification (user, arranger, admin peuvent voir les détails)
Route::middleware('auth')->group(function () {
    Route::get('/partitions/{partition}', [PartitionController::class, 'show'])->name('partitions.show');
});

// Routes pour arrangers et admins (création, modification, suppression)
Route::middleware(['auth'])->group(function () {
    Route::get('/partitions/create', [PartitionController::class, 'create'])->name('partitions.create');
    Route::post('/partitions', [PartitionController::class, 'store'])->name('partitions.store');
    Route::get('/partitions/{partition}/edit', [PartitionController::class, 'edit'])->name('partitions.edit');
    Route::put('/partitions/{partition}', [PartitionController::class, 'update'])->name('partitions.update');
    Route::delete('/partitions/{partition}', [PartitionController::class, 'destroy'])->name('partitions.destroy');
});

