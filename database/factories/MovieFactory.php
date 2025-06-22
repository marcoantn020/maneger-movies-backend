<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usersIds = User::query()->pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($usersIds),
            'title' => $this->faker->unique()->sentence(3),
            'year' => 1991,
            'genre' => $this->faker->randomElement(['Ação', 'Comédia', 'Drama', 'Terror', 'Ficção', 'Romance']),
            'synopsis' => $this->faker->paragraph(3),
            'poster_url' => $this->faker->imageUrl(640, 960, 'movies', true, 'Movie'),
        ];
    }
}
