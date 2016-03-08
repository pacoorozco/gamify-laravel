<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Gamify\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

/*
 * Badges Factory
 *
 * Create a badge with the name of a color :-D
 *
 */
$factory->define(\Gamify\Badge::class, function (Faker\Generator $faker) {

    $color = $faker->unique()->safeColorName;

    return [
        'name' => $color,
        'description' => 'This badge is for people who thinks in ' . $color . ' :D',
        'amount_needed' => 5,
    ];
});

