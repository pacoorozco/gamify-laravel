<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 - 2020 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 - 2020 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Tests\Unit;

use Gamify\User;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Tests\ModelTestCase;

class UserTest extends ModelTestCase
{
    public function test_contains_valid_fillable_properties()
    {
        $m = new User();
        $this->assertEquals([
            'name',
            'username',
            'email',
            'password',
        ], $m->getFillable());
    }

    public function test_contains_valid_hidden_properties()
    {
        $m = new User();
        $this->assertEquals([
            'password',
            'remember_token',
        ], $m->getHidden());
    }

    public function test_contains_valid_casts_properties()
    {
        $m = new User();
        $this->assertEquals([
            'id' => 'int',
            'name' => 'string',
            'username' => 'string',
            'email' => 'string',
            'password' => 'string',
            'role' => 'string',
            'last_login_at' => 'datetime',
        ], $m->getCasts());
    }

    public function test_username_is_lowercase()
    {
        $m = new User();

        $test_data = [
            'User' => 'user',
            'ADMIN' => 'admin',
            'user' => 'user',
            'admin' => 'admin',
        ];

        foreach ($test_data as $input => $want) {
            $m->username = $input;
            $this->assertEquals($want, $m->getAttribute('username'));
        }
    }

    public function test_password_is_hashed()
    {
        $m = new User();

        $test_data = [
            'secret',
            'verysecret',
            '$2y$04$pmfLKo7TAgmh.JyUT7iSneUCqwowvTvkmV1CO5tHGhue2L1viNvTW',
        ];

        foreach ($test_data as $input) {
            $m->password = $input;
            $this->assertTrue(Hash::check($input, $m->getAttribute('password')));
        }
    }

    public function test_getLastLoggedDate_is_formatted()
    {
        $m = new User();

        $test_data = [
            '1 day ago' => today()->subDay(),
            '3 days ago' => today()->subDays(3),
            '1 week ago' => today()->subWeek(),
            '3 weeks ago' => today()->subWeeks(3),
            '28 Jan 1977, 12:00am' => Carbon::createFromDate(1977, 1, 28),
        ];

        foreach ($test_data as $want => $input) {
            $m->last_login_at = $input->toDateString();
            $this->assertEquals($want, $m->getLastLoggedDate());
        }
    }

    public function test_isAdmin_returns_properly()
    {
        $m = new User();

        $test_data = [
            'administrator' => true,
            'user' => false,
            'editor' => false,
        ];

        foreach ($test_data as $input => $want) {
            $m->role = $input;
            $this->assertEquals($want, $m->isAdmin());
        }
    }

    public function test_profile_relation()
    {
        $m = new User();
        $r = $m->profile();
        $this->assertInstanceOf(HasOne::class, $r);
    }
}
