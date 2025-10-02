<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'artist_id' => \App\Models\Artist::factory(), // creates and links an artist
            // 'artist' => $this->faker->name(),
            'release_year' => $this->faker->year(),
            'genre' => $this->faker->word(),
            'cover_image' => $this->faker->imageUrl(300, 300, 'music', true, 'Album Cover'),
        ];
    }
}

