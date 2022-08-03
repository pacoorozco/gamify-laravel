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
    'active' => 'Active',

    'required_repetitions' => 'Repetitions',
    'required_repetitions_help' => 'Then number of times that the badge should be triggered to complete it as an achievement.',

    'image_help' => 'Image will be used as 220px, 128px and 64px squared sizes.',

    'actuators' => 'Event',
    'actuators_help' => 'The badge will listen to the selected event and add one repetition. Or you can trigger it by your own.',

    'tags' => 'Tags',
    'tags_placeholder' => 'Enter the tags separated by commas.',
    'tags_help' => 'Only the questions matching with one of these tags will trigger the completion of the badge.',
    'tags_none' => 'None',
];
