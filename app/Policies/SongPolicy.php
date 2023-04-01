<?php

namespace App\Policies;

use App\Models\Song;
use App\Models\User;

class SongPolicy
{
    /**
     * Determine if the given user can create songs.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create songs');
    }

    /**
     * Determine if the given song can be updated by the user.
     */
    public function update(User $user, Song $song): bool
    {
        return $user->hasPermissionTo('edit songs');
    }

    /**
     * Determine if the given song can be deleted by the user.
     */
    public function delete(User $user, Song $song): bool
    {
        return $user->hasPermissionTo('delete songs');
    }
}
