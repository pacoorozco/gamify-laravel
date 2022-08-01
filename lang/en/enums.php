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

    BadgeActuators::class => [
        BadgeActuators::None => 'None, I will trigger it by my own',

        BadgeActuators::OnQuestionAnswered => 'Question has been answered',
        BadgeActuators::OnQuestionCorrectlyAnswered => 'Question has been answered correctly',
        BadgeActuators::OnQuestionIncorrectlyAnswered => 'Question has been answered incorrectly',

        BadgeActuators::OnUserLogin => 'User has logged in',
    ],

    QuestionActuators::class => [
        QuestionActuators::OnQuestionAnswered => 'Always',
        QuestionActuators::OnQuestionCorrectlyAnswered => 'On question correctly answered',
        QuestionActuators::OnQuestionIncorrectlyAnswered => 'On question incorrectly answered',
    ],

    Roles::class => [
        Roles::Admin => 'Administrator',
        Roles::Player => 'Player',
    ],

];
