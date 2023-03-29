<?php

use App\Models\Playlist;
use App\Models\User;
use function Pest\Laravel\{actingAs, assertDatabaseHas, assertDatabaseMissing, get, post, put, delete};
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $user = User::factory()->create();
    $this->user = $user;
    actingAs($user);
});

it('can all be viewed', function () {
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

it('has create form', function () {
    get('/playlists/create')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Playlists/Create')
        );
});

it('can be created', function () {
    post('/playlists', [
        'name' => 'A new playlist',
    ])
    ->assertRedirect();

    assertDatabaseHas(Playlist::class, [
        'name' => 'A new playlist',
    ]);
});

it('can be viewed', function () {
    $playlist = Playlist::factory()->create();

    get('/playlists/'.$playlist->id)
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Playlists/Show')
            ->has('playlist', fn (Assert $page) => $page
                ->where('name', $playlist->name)
                ->etc()
            )
        );
});

it('has update form', function () {
    $playlist = Playlist::factory()->create();
    get('/playlists/'.$playlist->id.'/edit')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Playlists/Edit')
            ->has('playlist')
        );
});

it('can be updated', function () {
    $playlist = Playlist::factory()->create([
        'name' => 'old playlist name',
    ]);

    put('/playlists/'.$playlist->id, [
        'name' => 'new playlist name',
    ])
    ->assertRedirect();

    assertDatabaseHas(Playlist::class, [
        'name' => 'new playlist name',
    ]);
});

it('can be deleted', function () {
    $playlist = Playlist::factory()->create();

    delete('/playlists/'.$playlist->id)
        ->assertNoContent();

    assertDatabaseMissing(Playlist::class, [
        'id' => $playlist->id,
    ]);
});
