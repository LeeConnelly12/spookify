<?php

namespace App\Policies;

use App\Models\Song;
use App\Models\User;

class SongPolicy
{
    /**
     * Determine if the given song can be updated by the user.
     */
    public function update(User $user, Song $song): bool
    {
        return $user->id === $song->user_id;
    }
}
