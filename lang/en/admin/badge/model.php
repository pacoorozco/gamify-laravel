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
    'name' => 'Name',
    'image' => 'Image',
    'description' => 'Description',
    'required_repetitions' => 'Repetitions',
    'active' => 'Active',
    'required_repetitions_help' => 'How many times you need to repeat this to obtain this badge.',
    'image_help' => 'Image will be used as 220px, 128px and 64px squared sizes.',
    'actuators' => 'Actuators',
    'actuators_help' => 'It will listen to the selected events and trigger the badge for completion. Additionally, you can associate this badge to specific question, just go to the question edit form.',

    'actuators_related_with_question_events' => 'Question related events',
    'actuators_related_with_user_events' => 'User related events',

];
