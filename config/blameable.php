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

use Gamify\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Guard
    |--------------------------------------------------------------------------
    |
    | Please specify your default authentication guard to be used by blameable
    | service. You can leave this to null if you're using the default Laravel
    | authentication guard.
    |
    | You can also override this value in model classes to use a different
    | authentication guard for your specific models.
    | IE: Some of your models can only be created / updated by specific users
    | who logged in from a specific authentication guard.
    |
    */

    'guard' => null,

    /*
    |--------------------------------------------------------------------------
    | User Model Definition
    |--------------------------------------------------------------------------
    |
    | Please specify a user model that should be used to setup `creator`
    | and `updater` relationship.
    |
    */

    'user' => User::class,

    /*
    |--------------------------------------------------------------------------
    | The `createdBy` attribute
    |--------------------------------------------------------------------------
    |
    | Please define an attribute to use when recording the creator
    | identifier.
    |
    */

    'createdBy' => 'created_by',

    /*
    |--------------------------------------------------------------------------
    | The `updatedBy` attribute
    |--------------------------------------------------------------------------
    |
    | Please define an attribute to use when recording the updater
    | identifier.
    |
    */

    'updatedBy' => 'updated_by',

    /*
    |--------------------------------------------------------------------------
    | The `deletedBy` attribute
    |--------------------------------------------------------------------------
    |
    | Please define an attribute to use when recording the user
    | identifier who deleted the record. This feature would only work
    | if you are using SoftDeletes in your model.
    |
    */

    'deletedBy' => 'deleted_by',
];
