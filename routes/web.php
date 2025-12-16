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
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CommentManagementController;

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

// Routes nécessitant une authentification (user, arranger, admin)
Route::middleware('auth')->group(function () {

    // --- 1. ROUTES SPÉCIFIQUES (DOIVENT ÊTRE EN PREMIER) ---

    // Création (Avant le show !)
    Route::get('/partitions/create', [PartitionController::class, 'create'])->name('partitions.create');
    Route::post('/partitions', [PartitionController::class, 'store'])->name('partitions.store');

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

    // Admin management routes
    Route::middleware('can:manage-users')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

        Route::get('/comments', [CommentManagementController::class, 'index'])->name('comments.index');
        Route::delete('/comments/{comment}', [CommentManagementController::class, 'destroy'])->name('comments.destroy');
    });
});
