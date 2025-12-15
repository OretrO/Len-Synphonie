<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Traite l'inscription d'un nouvel utilisateur.
     */
    public function register(RegisterRequest $request)
    {
        // Gestion de l'avatar
        $avatarPath = null;

        if ($request->hasFile('avatar')) {
            $avatarPath = $this->handleAvatar($request->file('avatar'));
        } else {
            // Avatar par défaut
            $avatarPath = 'avatars/default.svg';
        }

        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $avatarPath,
            'role' => 'user', // Rôle par défaut
        ]);

        // Redirection avec message de succès
        return redirect()->route('home')->with('success', 'Votre compte a été créé avec succès ! Vous pouvez maintenant vous connecter.');
    }

    /**
     * Traite l'upload et le redimensionnement de l'avatar.
     */
    private function handleAvatar($file)
    {
        // Génération d'un nom unique
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Stocker le fichier dans storage/app/public/avatars
        $file->storeAs('public/avatars', $filename);

        return 'avatars/' . $filename;
    }
}
