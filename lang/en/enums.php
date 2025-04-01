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

use Gamify\Enums\BadgeActuators;
use Gamify\Enums\QuestionActuators;
use Gamify\Enums\Roles;

return [

    'actuators_related_with_question_events' => 'Question related events',
    'actuators_related_with_user_events' => 'User related events',

    'badge_actuators' => [
        'none' => 'None, I will trigger it by my own',

        'on_question_answered' => 'Question has been answered',
        'on_question_correctly_answered' => 'Question has been answered correctly',
        'on_question_incorrectly_answered' => 'Question has been answered incorrectly',

        'on_user_login' => 'User has logged in',
        'on_user_profile_updated' => 'User has updated its profile',
        'on_user_avatar_uploaded' => 'User has uploaded an avatar',
    ],

    'question_actuators' => [
        'on_question_answered' => 'Always',
        'on_question_correctly_answered' => 'On question correctly answered',
        'on_question_incorrectly_answered' => 'On question incorrectly answered',
    ],

    'roles' => [
        'admin' => 'Administrator',
        'player' => 'Player',
    ],

];
