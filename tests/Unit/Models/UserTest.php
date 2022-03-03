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

use Gamify\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function contains_valid_fillable_properties()
    {
        $m = new User();

        $this->assertEquals([
            'name',
            'username',
            'email',
            'password',
            'role',
        ], $m->getFillable());
    }

    /** @test */
    public function contains_valid_hidden_properties()
    {
        $m = new User();

        $this->assertEquals([
            'password',
            'remember_token',
        ], $m->getHidden());
    }

    /** @test */
    public function contains_valid_casts_properties()
    {
        $m = new User();

        $this->assertEquals([
            'id' => 'int',
        ], $m->getCasts());
    }

    /** @test */
    public function getLastLoggedDate_is_formatted_when_user_logged_in()
    {
        $m = new User();
        $test_cases = [
            [
                'input' => today()->subDay(),
                'want' => '1 day ago',
            ],
            [
                'input' => today()->subDays(3),
                'want' => '3 days ago',
            ],
            [
                'input' => today()->subWeek(),
                'want' => '1 week ago',
            ],
            [
                'input' => today()->subWeeks(3),
                'want' => '3 weeks ago',
            ],
        ];

        foreach ($test_cases as $current_test) {
            $m->last_login_at = $current_test['input'];

            $this->assertEquals($current_test['want'], $m->getLastLoggedDate());
        }
    }

    /** @test */
    public function getLastLoggedDate_is_not_available_when_user_has_not_logged_in()
    {
        $m = new User();

        $this->assertEquals('N/A', $m->getLastLoggedDate());
    }

    /** @test */
    public function isAdmin_returns_properly()
    {
        $m = new User();

        $test_data = [
            'administrator' => true,
            'user' => false,
            'editor' => false,
            'randomWord' => false,
        ];

        foreach ($test_data as $input => $want) {
            $m->role = $input;

            $this->assertEquals($want, $m->isAdmin());
        }
    }

    /** @test */
    public function profile_relation()
    {
        $m = new User();

        $r = $m->profile();

        $this->assertInstanceOf(HasOne::class, $r);
    }

    /** @test */
    public function answeredQuestions_relation()
    {
        $m = new User();

        $r = $m->answeredQuestions();

        $this->assertInstanceOf(BelongsToMany::class, $r);
    }

    /** @test */
    public function badges_relation()
    {
        $m = new User();

        $r = $m->badges();

        $this->assertInstanceOf(BelongsToMany::class, $r);
    }

    /** @test */
    public function points_relation()
    {
        $m = new User();

        $r = $m->points();

        $this->assertInstanceOf(HasMany::class, $r);
    }

    /** @test */
    public function accounts_relation()
    {
        $m = new User();

        $r = $m->accounts();

        $this->assertInstanceOf(HasMany::class, $r);
    }

    /** @test */
    public function lowercase_username_when_set()
    {
        $m = new User();

        $test_data = [
            'User' => 'user',
            'ADMIN' => 'admin',
            'user' => 'user',
            'admin' => 'admin',
            '12345' => '12345',
        ];

        foreach ($test_data as $input => $want) {
            $m->username = $input;

            $this->assertEquals($want, $m->getAttribute('username'));
        }
    }

    /** @test */
    public function hashes_password_when_set()
    {
        Hash::shouldReceive('make')->once()->andReturn('hashed');

        $m = new User();
        $m->password = 'plain';

        $this->assertEquals('hashed', $m->password);
    }
}
