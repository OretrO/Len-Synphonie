<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Affiche la page de profil.
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Met à jour les informations du profil.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validation des données (Source: 91, 110, 111, 112)
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:50', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048', 'dimensions:max_width=512,max_height=512'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::defaults()], // Règles par défaut de Laravel (min 8 car, etc.)
        ]);

        // 2. Mise à jour de l'Avatar
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar s'il existe et n'est pas celui par défaut
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Stocker le nouveau (dans storage/app/public/avatars)
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 3. Mise à jour des infos textuelles
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // 4. Mise à jour du mot de passe (si renseigné)
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('status', 'Profil mis à jour avec succès !');
    }
}
