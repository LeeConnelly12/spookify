<?php

use App\Models\Album;
use function Pest\Laravel\{get};
use Inertia\Testing\AssertableInertia as Assert;

it('can be viewed', function () {
    $album = Album::factory()->create();

    get('/albums/'.$album->id)
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Albums/Show')
            ->has('album', fn (Assert $page) => $page
                ->where('name', $album->name)
                ->etc()
            )
        );
});
