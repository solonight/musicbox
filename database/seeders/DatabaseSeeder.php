<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create 200 artists
        $artists = \App\Models\Artist::factory(200)->create();

        // Create 200 albums, each linked to a random artist
        $albums = collect();
        for ($i = 0; $i < 200; $i++) {
            $albums->push(
                \App\Models\Album::factory()->create([
                    'artist_id' => $artists->random()->id,
                ])
            );
        }

        // Create 200 songs, each linked to a random album
        for ($i = 0; $i < 200; $i++) {
            \App\Models\Song::factory()->create([
                'album_id' => $albums->random()->id,
            ]);
        }

        $this->call(LaratrustSeeder::class);
    }
}
