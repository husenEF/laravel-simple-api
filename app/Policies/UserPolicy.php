<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Allow GET /users for API
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Allow POST /users for API
     */
    public function create(?User $user): bool
    {
        return true;
    }

    /**
     * Optional: allow viewing a single user
     */
    public function view(?User $user, User $model): bool
    {
        return true;
    }

    /**
     * Customize these for your roles later if needed
     */
    public function update(User $user, User $model): bool
    {
        if ($user->role === 'administrator') {
            return true;
        }

        if ($user->role === 'manager' && $model->role === 'user') {
            return true;
        }

        return $user->id === $model->id;
    }


    public function delete(User $user, User $model): bool
    {
        return false; // keep disabled
    }

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
