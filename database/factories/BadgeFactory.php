<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Database\Factories;

use Gamify\Enums\BadgeActuators;
use Illuminate\Database\Eloquent\Factories\Factory;

class BadgeFactory extends Factory
{
    public function definition(): array
    {
        $color = $this->faker->unique()->safeColorName;

        return [
            'name' => $color,
            'description' => 'This badge is for people who think about '.$color.' :D',
            'required_repetitions' => 5,
            'active' => $this->faker->boolean,
            'actuators' => $this->faker->randomElement(BadgeActuators::getValues()),
        ];
    }

    public function active(): Factory
    {
        return $this->state(fn () => [
            'active' => true,
        ]);
    }

    public function inactive(): Factory
    {
        return $this->state(fn () => [
            'active' => false,
        ]);
    }

    public function withActuators(array $actuators): Factory
    {
        return $this->state(function () use ($actuators) {
            return [
                'actuators' => BadgeActuators::flags($actuators),
            ];
        });
    }
}
