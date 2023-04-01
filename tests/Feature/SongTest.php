<?php

use App\Models\Song;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\{actingAs, assertDatabaseHas, assertDatabaseMissing, get};

it('can all be viewed', function () {
    $songs = Song::factory()->count(3)->create();

    get('/songs')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Songs/Index')
            ->has('songs', 3, fn (Assert $page) => $page
                ->where('name', $songs->first()->name)
                ->etc()
            )
        );
});

it('can be viewed', function () {
    $song = Song::factory()->create();

    get('/songs/'.$song->id)
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Songs/Show')
            ->has('song')
        );
});

it('can be created by an artist', function () {
    $artist = User::factory()->create();
    $artist->assignRole('artist');

    actingAs($artist)
        ->post('/songs', [
            'name' => 'new song',
        ])
        ->assertRedirect();

    assertDatabaseHas(Song::class, [
        'name' => 'new song',
    ]);
});

it('cannot be created by a non-artist', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->post('/songs', [
            'name' => 'new song',
        ])
        ->assertForbidden();
});

it('can be updated by the artist that created the song', function () {
    $artist = User::factory()->create();
    $artist->assignRole('artist');

    $song = Song::factory()
        ->for($artist)
        ->create(['name' => 'old name']);

    actingAs($artist)
        ->put('/songs/'.$song->id, [
            'name' => 'new name',
        ])
        ->assertRedirect();

    assertDatabaseHas(Song::class, [
        'name' => 'new name',
    ]);
});

it('can only be updated by the artist that created the song', function () {
    $artist = User::factory()->create();
    $artist->assignRole('artist');

    $otherArtist = User::factory()->create();
    $otherArtist->assignRole('artist');

    $song = Song::factory()->for($artist)->create();

    actingAs($otherArtist)
        ->put('/songs/'.$song->id, [
            'name' => 'new name',
        ])
        ->assertForbidden();
});

it('can be deleted by the artist that created the song', function () {
    $artist = User::factory()->create();
    $artist->assignRole('artist');

    $song = Song::factory()->for($artist)->create();

    actingAs($artist)
        ->delete('/songs/'.$song->id)
        ->assertRedirect('/songs');

    assertDatabaseMissing(Song::class, [
        'id' => $song->id,
    ]);
});

it('can only be deleted by the artist that created the song', function () {
    $artist = User::factory()->create();
    $artist->assignRole('artist');

    $otherArtist = User::factory()->create();
    $otherArtist->assignRole('artist');

    $song = Song::factory()->for($artist)->create();

    actingAs($otherArtist)
        ->delete('/songs/'.$song->id)
        ->assertForbidden();
});
