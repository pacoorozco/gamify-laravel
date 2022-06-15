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

namespace Gamify\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class UsernameRule implements Rule
{
    // Based on 'The Open Group Base Specifications Issue 7, 2018 edition'.
    // https://pubs.opengroup.org/onlinepubs/9699919799/basedefs/V1_chap03.html#tag_03_437
    const VALID_USERNAME_REGEXP = '/^[A-Za-z\d][A-Za-z\d._-]*$/';

    public function passes($attribute, $value): bool
    {
        if (Str::length($value) < 1 || Str::length($value) > 255) {
            return false;
        }

        return 1 == preg_match(self::VALID_USERNAME_REGEXP, $value);
    }

    public function message(): string
    {
        return 'The :attribute is not a valid POSIX username.';
    }
}
