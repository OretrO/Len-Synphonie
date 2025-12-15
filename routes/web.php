<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PartitionController;
use App\Http\Controllers\ArrangementController;

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
