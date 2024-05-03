<?php

namespace App\Policies;

use App\Models\User;

class LendingBookPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->role == 'admin'
               || $user->role == 'client';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == 'admin';
    }
}
