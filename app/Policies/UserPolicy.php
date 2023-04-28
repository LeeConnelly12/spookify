<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the given user can be updated by the user.
     */
    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
}
