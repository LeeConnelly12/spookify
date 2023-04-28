<?php

use App\Models\User;
use function Pest\Laravel\{actingAs, put};

it('can update profile', function () {
    $user = User::factory()->create([
        'name' => 'old name',
    ]);

    actingAs($user)
        ->put('/profile', [
            'name' => 'new name',
        ])
        ->assertRedirect();

    $user->refresh();

    expect($user->name)->toBe('new name');
});
