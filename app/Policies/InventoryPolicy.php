<?php

namespace App\Policies;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InventoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('View Inventory')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Inventory $inventory): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('View Inventory')) {
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
            $user->hasPermissionTo('Create Inventory')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inventory $inventory): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('Edit Inventory')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inventory $inventory): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('Delete Inventory')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete any the model.
     */
    public function deleteAny(User $user): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('Delete Inventory')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Inventory $inventory): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('Restore Inventory')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore any the model.
     */
    public function restoreAny(User $user): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('Restore Inventory')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Inventory $inventory): bool
    {
        if ($user->hasRole('admin') || 
            $user->hasPermissionTo('Delete Inventory')) {
            return true;
        }
        return false;
    }
}
