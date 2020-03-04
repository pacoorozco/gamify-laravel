<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 - 2020 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 - 2020 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

use Faker\Generator as Faker;
use Gamify\User;
use Illuminate\Support\Str;

// To create a user with fake information
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => 'secret',
        'role' => User::DEFAULT_ROLE,
        'remember_token' => Str::random(10),
        'last_login_at' => $faker->dateTime,
    ];
});

// To create a user with 'administrator' role.
$factory->state(User::class, 'admin', [
    'role' => User::ADMIN_ROLE,
]);
