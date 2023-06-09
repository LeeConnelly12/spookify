<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'album_id' => Album::factory(),
            'user_id' => User::factory(),
            'name' => fake()->realText(25),
            'year' => fake()->numberBetween(2000, 2020),
            'duration' => fake()->numberBetween(10, 600),
        ];
    }
}
