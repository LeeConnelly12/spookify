<?php

use App\Models\Song;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\{actingAs, assertDatabaseHas, assertDatabaseMissing, get};

it('can all be viewed', function () {
    $songs = Song::factory()->count(3)->create();

    get('/songs')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Songs/Index')
            ->has('songs', 3, fn (Assert $page) => $page
                ->whereAll([
                    'name' => $songs->first()->name,
                    'year' => $songs->first()->year,
                    'url' => Storage::url($songs->first()->url),
                ])
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
    Storage::fake();

    $artist = User::factory()->create();
    $artist->assignRole('artist');

    $file = UploadedFile::fake()->create('song.mp3', 1024);

    actingAs($artist)
        ->post('/songs', [
            'name' => 'new song',
            'year' => 2000,
            'file' => $file,
        ])
        ->assertRedirect();

    assertDatabaseHas(Song::class, [
        'name' => 'new song',
        'year' => 2000,
        'url' => 'songs/'.$file->hashName(),
    ]);

    Storage::assertExists('songs/'.$file->hashName());
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
    Storage::fake();

    $artist = User::factory()->create();
    $artist->assignRole('artist');
    $file = UploadedFile::fake()->create('song.mp3', 1024);

    $song = Song::factory()
        ->for($artist)
        ->create([
            'name' => 'old name',
            'year' => 2000,
        ]);

    actingAs($artist)
        ->put('/songs/'.$song->id, [
            'name' => 'new name',
            'year' => 2015,
            'file' => $file,
        ])
        ->assertRedirect();

    assertDatabaseHas(Song::class, [
        'name' => 'new name',
        'year' => 2015,
        'url' => 'songs/'.$file->hashName(),
    ]);

    Storage::assertExists('songs/'.$file->hashName());
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
