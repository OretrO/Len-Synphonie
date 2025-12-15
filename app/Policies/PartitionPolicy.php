<?php

namespace App\Policies;

use App\Models\Partition;
use App\Models\User;

class PartitionPolicy
{
    /**
     * Determine whether the user can view any partitions.
     * Visitors (guests) are allowed to see the list of partitions.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the partition.
     * Visitors cannot view a specific partition; any authenticated user can.
     */
    public function view(?User $user, Partition $partition): bool
    {
        if ($user === null) {
            return false;
        }

        // All authenticated users can access a partition detail page
        return true;
    }

    /**
     * Determine whether the user can create partitions.
     * Only authenticated users with role arranger or admin can create.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['arranger', 'admin']);
    }

    /**
     * Determine whether the user can update the partition.
     * Owner (creator) and admin are allowed.
     */
    public function update(User $user, Partition $partition): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $partition->user_id;
    }

    /**
     * Determine whether the user can delete the partition.
     * Same rule as update: owner or admin.
     */
    public function delete(User $user, Partition $partition): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->id === $partition->user_id;
    }
}
