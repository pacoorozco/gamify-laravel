<?php

namespace Database\Factories;

use Gamify\Models\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Point>
 */
class PointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'points' => 1,
            'description' => 'You learned the word: '.fake()->word,
        ];
    }
}
