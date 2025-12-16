<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function manageUsers(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, User $target): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $target->id;
    }

    public function delete(User $user, User $target): bool
    {
        if ($user->role !== 'admin') {
            return false;
        }

        // empêcher un admin de se supprimer lui-même
        return $user->id !== $target->id;
    }
}

