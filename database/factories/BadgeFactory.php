<?php

use Faker\Generator as Faker;

$factory->define(Gamify\Badge::class, function (Faker $faker) {

    $color = $faker->unique()->safeColorName;

    return [
        'name'                 => $color,
        'description'          => 'This badge is for people who thinks in ' . $color . ' :D',
        'required_repetitions' => 5,
    ];
});
