<?php

namespace Database\Factories;

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
            'title' => $this->faker->sentence(3),
            'duration' => $this->faker->numberBetween(120, 300),
            'release_date' => $this->faker->date(),
            'genre' => $this->faker->word(),
            // 'album_id' will be set in the seeder
        ];
    }
}
