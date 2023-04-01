<?php

use App\Models\Song;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\{actingAs, get};

beforeEach(function () {
    $user = User::factory()->create();
    $this->user = $user;
    actingAs($user);
});

it('has liked songs page', function () {
    $this->user->likedSongs()
        ->attach(Song::factory()->count(3)->create());

    $song = $this->user->likedSongs()->first();

    get('/songs')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Songs/Liked/Index')
            ->has('songs', 3, fn (Assert $page) => $page
                ->whereAll([
                    'id' => $song->id,
                    'name' => $song->name,
                    'year' => $song->year,
                ])
                ->etc()
            )
        );
});

it('can be liked', function () {
    $song = Song::factory()->create();

    actingAs($this->user)
        ->put('/songs/'.$song->id.'/like')
        ->assertNoContent();

    expect($this->user->likedSongs)->not->tobeEmpty();
});

it('can be unliked', function () {
    $this->user->likedSongs()->attach(Song::factory()->create());
    $song = $this->user->likedSongs->first();

    actingAs($this->user)
        ->delete('/songs/'.$song->id.'/unlike')
        ->assertNoContent();

    $this->user->refresh();

    expect($this->user->likedSongs)->tobeEmpty();
});
