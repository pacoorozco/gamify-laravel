<?php

namespace Database\Factories;

use Gamify\Models\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

class LevelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Level::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $color = $this->faker->unique()->safeColorName;

        return [
            'name' => 'Level ' . $color,
            'required_points' => $this->faker->unique()->randomNumber() + 5,
            'active' => true,
        ];
    }
}
