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

use Gamify\Enums\Roles;
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
            'role' => Roles::class,
        ], $m->getCasts());
    }

    /**
     * @test
     * @dataProvider provideDataToTestAdminMembership
     */
    public function it_should_return_if_user_is_admin(
        string $role,
        bool $shouldBeAdmin,
    ) {
        $m = new User();

        $m->role = $role;

        $this->assertEquals($shouldBeAdmin, $m->isAdmin());
    }

    public function provideDataToTestAdminMembership(): \Generator
    {
        yield 'Administrator' => [
            'role' => Roles::Admin,
            'want' => true,
        ];

        yield 'Player' => [
            'role' => Roles::Player,
            'want' => false,
        ];
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
