<?php

namespace Database\Factories;

use Gamify\Enums\BadgeActuators;
use Gamify\Models\Badge;
use Illuminate\Database\Eloquent\Factories\Factory;

class BadgeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Badge::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $color = $this->faker->unique()->safeColorName;

        return [
            'name' => $color,
            'description' => 'This badge is for people who think about ' . $color . ' :D',
            'required_repetitions' => 5,
            'actuators' => BadgeActuators::None()->value,
        ];
    }
}
