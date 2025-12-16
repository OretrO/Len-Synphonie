<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartitionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ArrangementController;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// Routes d'inscription
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Route de connexion temporaire
Route::get('/login', function () {
    return redirect()->route('home');
})->name('login');

// Routes des partitions
Route::resource('partitions', PartitionController::class)->only(['index', 'show']);

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    Route::resource('partitions', PartitionController::class)->only([
        'create', 'store', 'edit', 'update', 'destroy',
    ]);

    Route::resource('arrangements', ArrangementController::class)->only([
        'index', 'show', 'create', 'store', 'edit', 'update', 'destroy',
    ]);
});
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
