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

it('can be viewed', function () {
    $playlists = Playlist::factory()
        ->for($this->user)
        ->count(3)
        ->create();

    get('/playlists')
        ->assertInertia(fn (Assert $page) => $page
            ->component('Playlists/Index')
            ->has('playlists', 3, fn (Assert $page) => $page
                ->where('name', $playlists->first()->name)
                ->etc()
            )
        );
});
