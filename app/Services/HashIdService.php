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

namespace Gamify\Services;

use Hashids\Hashids;

class HashIdService
{
    protected Hashids $hashIds;

    public function __construct()
    {
        $salt = config('app.hashids.salt', '');
        $length = config('app.hashids.length', 0);
        $alphabet  = config('app.hashids.alphabet', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

        // IMPORTANT! A weak hash can expose the entire app:
        // http://carnage.github.io/2015/08/cryptanalysis-of-hashids
        $salt = hash('sha256', $salt);

        $this->hashIds = new Hashids($salt, $length, $alphabet);
    }

    public function encode(int $id): string
    {
        return $this->hashIds->encode($id);
    }

    public function decode(int|string $hashId): int
    {
        if (is_int($hashId)) {
            return $hashId;
        }

        return $this->hashIds->decode($hashId)[0];
    }
}
