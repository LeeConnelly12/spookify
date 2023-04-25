<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Song;
use App\Models\User;
use App\Models\Playlist;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);

        $artist = User::factory()->create([
            'name' => 'artist',
            'email' => 'artist@example.com',
            'password' => bcrypt('password'),
        ]);

        $artist->assignRole('artist');

        Song::factory()->for($artist)->count(10)->create();

        Playlist::factory()
            ->for($artist)
            ->has(Song::factory()->count(10))
            ->create();
    }
}
