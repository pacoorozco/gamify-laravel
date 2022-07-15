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

use Illuminate\Contracts\Validation\ImplicitRule;
use Illuminate\Support\Str;

class UsernameRule implements ImplicitRule
{
    /**
     * Based on POSIX set of valid usernames:
     * Lower and upper case ASCII letters, digits, period, underscore, and hyphen, with the
     * restriction that hyphen is not allowed as first character of the user name.
     *
     * @see https://systemd.io/USER_NAMES/
     */
    const VALID_USERNAME_REGEXP = '/^[A-Za-z\d][A-Za-z\d._-]*$/';

    public function passes($attribute, $value): bool
    {
        if (Str::length($value) < 1 || Str::length($value) > 255) {
            return false;
        }

        return 1 == preg_match(self::VALID_USERNAME_REGEXP, $value);
    }

    public function message(): string|array
    {
        return __('validation.username')
            ?? 'The :attribute is not a valid POSIX username.';
    }
}
