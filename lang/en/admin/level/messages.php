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
    'already_exists' => 'Level already exists!',
    'does_not_exist' => 'Level does not exist.',
    'name_required' => 'The name field is required',

    'create' => [
        'error' => 'Level was not created, please try again.',
        'success' => 'Level created successfully.',
    ],

    'update' => [
        'error' => 'Level was not updated, please try again',
        'success' => 'Level updated successfully.',
    ],

    'delete' => [
        'error_default_level' => 'The default level can not be deleted',
        'error' => 'There was an issue deleting the level. Please try again.',
        'success' => 'The level was deleted successfully.',
    ],

    'danger_zone_section' => 'Danger Zone',
    'delete_button' => 'Delete this level',
    'delete_help' => 'Once you delete a level, there is no going back. Please be certain.',
    'delete_confirmation_warning' => 'This action <strong>cannot</strong> be undone. This will permanently delete the <strong>:name</strong> level.',
    'delete_confirmation_button' => 'I understand the consequences, delete this level',

];
