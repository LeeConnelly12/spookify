<?php

use App\Models\Song;
use Inertia\Testing\AssertableInertia as Assert;
use function Pest\Laravel\{get};

test('can all be viewed', function () {
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
