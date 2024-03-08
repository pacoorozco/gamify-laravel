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

namespace Tests\Unit\Models;

use Gamify\Models\UserProfile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

final class UserProfileTest extends TestCase
{
    public function test_contains_valid_fillable_properties(): void
    {
        $m = new UserProfile();
        $this->assertEquals([
            'bio',
            'date_of_birth',
            'twitter',
            'facebook',
            'linkedin',
            'github',
        ], $m->getFillable());
    }

    public function test_contains_valid_casts_properties(): void
    {
        $m = new UserProfile();
        $this->assertEquals([
            'id' => 'int',
            'date_of_birth' => 'date',
        ], $m->getCasts());
    }

    public function test_user_relation(): void
    {
        $m = new UserProfile();
        $r = $m->user();
        $this->assertInstanceOf(BelongsTo::class, $r);
    }
}
