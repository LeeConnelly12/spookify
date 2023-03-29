<?php

use App\Models\Song;
use App\Models\User;
use App\Models\Playlist;
use function Pest\Laravel\{actingAs, post, delete};

beforeEach(function () {
    $user = User::factory()->create();
    $this->user = $user;
    actingAs($user);
});

it('can add song to playlist', function () {
    $playlist = Playlist::factory()->create();
    $song = Song::factory()->create();

    post('/playlists/'.$playlist->id.'/songs', [
        'song_id' => $song->id,
    ])
    ->assertRedirect();

    expect($playlist->songs)->not->toBeEmpty();
});

it('can remove song from playlist', function () {
   $playlist = Playlist::factory()
        ->has(Song::factory())
        ->create();

    delete('/playlists/'.$playlist->id.'/songs', [
     'song_id' => $playlist->songs->first()->id,
    ])
    ->assertRedirect();

    $playlist->refresh();

    expect($playlist->songs)->toBeEmpty();
});
