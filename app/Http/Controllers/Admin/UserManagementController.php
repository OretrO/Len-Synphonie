<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    public function index()
    {
        Gate::authorize('manage-users');

        $users = User::orderBy('role')->orderBy('name')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        Gate::authorize('manage-users');

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('manage-users');

        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role'   => ['required', 'in:admin,arranger,user,visitor'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->role  = $validated['role'];

        if ($request->boolean('remove_avatar')) {
            if ($user->avatar && !Str::startsWith($user->avatar, 'avatars/default')) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = 'avatars/default.svg';
        } elseif ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');

            if ($user->avatar && !Str::startsWith($user->avatar, 'avatars/default')) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $path;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        Gate::authorize('manage-users');

        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
        }

        if ($user->avatar && !Str::startsWith($user->avatar, 'avatars/default')) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
