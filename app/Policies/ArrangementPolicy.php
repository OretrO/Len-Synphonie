<?php

namespace App\Policies;

use App\Models\Arrangement;
use App\Models\User;

class ArrangementPolicy
{
    /**
     * Determine whether the user can view any arrangements.
     * Only authenticated users can see the arrangements list.
     */
    public function viewAny(?User $user): bool
    {
        return $user !== null;
    }

    /**
     * Determine whether the user can view the arrangement.
     * Only authenticated users can view an arrangement; roles are handled by routes and other abilities.
     */
    public function view(?User $user, Arrangement $arrangement): bool
    {
        if ($user === null) {
            return false;
        }

        // Any authenticated user can play / view an arrangement
        return true;
    }

    /**
     * Determine whether the user can create arrangements.
     * Only arrangers and admins can create.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['arranger', 'admin']);
    }

    /**
     * Determine whether the user can update the arrangement.
     * Creator and admin are allowed.
     */
    public function update(User $user, Arrangement $arrangement): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $arrangement->creator_id;
    }

    /**
     * Determine whether the user can delete the arrangement.
     * Creator and admin are allowed.
     */
    public function delete(User $user, Arrangement $arrangement): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $arrangement->creator_id;
    }
}
