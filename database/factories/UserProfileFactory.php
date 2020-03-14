<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE, AUTHORS.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Gamify\UserProfile;

$factory->define(UserProfile::class, function (Faker $faker) {
    return [
        'bio' => $faker->text,
        'url' => $faker->url,
        'avatar' => $faker->imageUrl($width = 640, $height = 480, 'cats'),
        'phone' => $faker->e164PhoneNumber,
        'date_of_birth' => $faker->dateTime,
        'gender' => $faker->randomElement(['male', 'female', 'unspecified']),
        'twitter' => $faker->url,
        'facebook' => $faker->url,
        'linkedin' => $faker->url,
        'github' => $faker->url,
    ];
});
