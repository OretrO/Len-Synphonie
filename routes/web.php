<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartitionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController;

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

// Routes pour arrangers et admins (création, modification, suppression)
// IMPORTANT: /create doit être avant /{partition} pour éviter les conflits
Route::middleware(['auth'])->group(function () {
    Route::get('/partitions/create', [PartitionController::class, 'create'])->name('partitions.create');
    Route::post('/partitions', [PartitionController::class, 'store'])->name('partitions.store');
    Route::get('/partitions/{partition}/edit', [PartitionController::class, 'edit'])->name('partitions.edit');
    Route::put('/partitions/{partition}', [PartitionController::class, 'update'])->name('partitions.update');
    Route::delete('/partitions/{partition}', [PartitionController::class, 'destroy'])->name('partitions.destroy');
});

// Routes nécessitant une authentification (user, arranger, admin peuvent voir les détails)
Route::middleware('auth')->group(function () {
    Route::get('/partitions/{partition}', [PartitionController::class, 'show'])->name('partitions.show');
});

