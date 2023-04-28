<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        $user->load('playlists');

        return inertia('Users/Show', [
            'user' => new UserResource($user),
        ]);
    }
}
