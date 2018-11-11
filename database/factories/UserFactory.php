<?php

use Faker\Generator as Faker;

$factory->define(Gamify\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'remember_token' => str_random(10),
        'last_login_at' => $faker->dateTime,
    ];
});
