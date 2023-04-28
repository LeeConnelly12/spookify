<?php

use App\Models\Playlist;
use App\Models\User;
use function Pest\Laravel\{actingAs, get};
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $user = User::factory()->create();
    $this->user = $user;
    actingAs($user);
});

it('can view a user', function () {
    $user = User::factory()->create();

    $playlists = Playlist::factory()
        ->for($user)
        ->count(3)
        ->create();

    get('/users/' . $user->name)
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Users/Show')
            ->has('user', fn (Assert $page) => $page
                ->where('name', $user->name)
                ->has('playlists', 3, fn (Assert $page) => $page
                    ->where('name', $playlists->first()->name)
                    ->etc()
                )
                ->etc()
            )
        );
});
