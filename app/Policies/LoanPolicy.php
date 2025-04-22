<?php

namespace App\Policies;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LoanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
                if ($user->hasRole('admin') ||
            $user->hasPermissionTo('View Loan')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Loan $loan): bool
    {
                if ($user->hasRole('admin') ||
            $user->hasPermissionTo('View Loan')) {
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
            $user->hasPermissionTo('Create Loan')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Loan $loan): bool
    {
                if ($user->hasRole('admin') ||
            $user->hasPermissionTo('Edit Loan')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Loan $loan): bool
    {
                if ($user->hasRole('admin') ||
            $user->hasPermissionTo('Delete Loan')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Loan $loan): bool
    {
                if ($user->hasRole('admin') ||
            $user->hasPermissionTo('Restore Loan')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Loan $loan): bool
    {
                if ($user->hasRole('admin') ||
            $user->hasPermissionTo('Force Delete Loan')) {
            return true;
        }
        return false;
    }
}
