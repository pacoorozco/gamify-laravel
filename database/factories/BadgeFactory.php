<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Gamify\Badge;
use Gamify\Enums\BadgeActuators;

$factory->define(Badge::class, function (Faker $faker) {
    $color = $faker->unique()->safeColorName;

    return [
        'name' => $color,
        'description' => 'This badge is for people who thinks in '.$color.' :D',
        'required_repetitions' => 5,
        'actuators' => BadgeActuators::getRandomValue(),
    ];
});
