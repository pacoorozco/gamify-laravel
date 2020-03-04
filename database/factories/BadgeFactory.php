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
use Gamify\Badge;

$factory->define(Badge::class, function (Faker $faker) {
    $color = $faker->unique()->safeColorName;

    return [
        'name' => $color,
        'description' => 'This badge is for people who thinks in '.$color.' :D',
        'required_repetitions' => 5,
    ];
});
