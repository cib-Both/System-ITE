<?php

namespace App\Policies;

use App\Models\Locate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LocatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('View Locate')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Locate $locate): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('View Locate')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('Create Locate')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Locate $locate): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('Edit Locate')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Locate $locate): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('Delete Locate')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Locate $locate): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Locate $locate): bool
    {
        return false;
    }
}
