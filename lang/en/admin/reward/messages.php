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

return [
    'title' => 'Rewards',
    'header' => 'give experience or badge to users',
    'give_experience' => 'Give Experience',
    'give_badge' => 'Give Badge',
    'username' => 'Username',
    'points' => 'Points',
    'points_value' => ':points points',
    'message' => 'Message',
    'badge' => 'Badge',

    'pick_user' => 'Pick the user to be rewarded',
    'pick_points' => 'Pick how many points',
    'pick_badge' => 'Pick the badge',
    'why_u_reward' => 'Why are you rewarding this user?',

    'experience_given' => [
        'error' => 'Experience was not given to :username, please try again.',
        'success' => 'User :username received :points experience points.',
    ],
    'badge_given' => [
        'error' => 'Badge was not given to :username, please try again.',
        'success' => 'User :username received ":badge" badge.',
    ],
];
