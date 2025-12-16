<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    // Affiche le profil de l'utilisateur connecté
    public function show()
    {
        $user = Auth::user();

        return view('profile.show', compact('user'));
    }

    // Edition du profil (formulaire)
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    // Mise à jour du profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');

            // Supprimer l'ancien avatar si ce n'est pas le défaut
            if ($user->avatar && !Str::startsWith($user->avatar, 'avatars/default')) {
                try {
                    Storage::disk('public')->delete($user->avatar);
                } catch (\Throwable $e) {
                    // ignore
                }
            }

            $user->avatar = $path;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}
