<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Gamify\Level;

$factory->define(Level::class, function (Faker $faker) {
    $color = $faker->unique()->safeColorName;

    return [
        'name' => 'Level ' . $color,
        'required_points' => $faker->unique()->randomNumber() + 5,
        'active' => $faker->boolean,
    ];
});
