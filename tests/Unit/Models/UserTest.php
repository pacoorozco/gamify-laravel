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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Gamify\Enums\Roles;
use Gamify\Models\Level;
use Gamify\Models\User;
use Generator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

final class UserTest extends TestCase
{
    #[Test]
    public function contains_valid_fillable_properties(): void
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

    #[Test]
    public function contains_valid_hidden_properties(): void
    {
        $m = new User();

        $this->assertEquals([
            'password',
            'remember_token',
        ], $m->getHidden());
    }

    #[Test]
    public function contains_valid_casts_properties(): void
    {
        $m = new User();

        $this->assertEquals([
            'id' => 'int',
            'level' => Level::class,
            'role' => Roles::class,
            'email_verified_at' => 'datetime',
        ], $m->getCasts());
    }

    #[Test]
    #[DataProvider('provideDataToTestAdminMembership')]
    public function it_should_return_if_user_is_admin(
        string $role,
        bool $shouldBeAdmin,
    ): void {
        $m = new User();

        $m->role = Roles::from($role);

        $this->assertEquals($shouldBeAdmin, $m->isAdmin());
    }

    public static function provideDataToTestAdminMembership(): Generator
    {
        yield 'Administrator' => [
            'role' => Roles::ADMIN->value,
            'shouldBeAdmin' => true,
        ];

        yield 'Player' => [
            'role' => Roles::PLAYER->value,
            'shouldBeAdmin' => false,
        ];
    }

    #[Test]
    public function profile_relation(): void
    {
        $m = new User();

        $r = $m->profile();

        $this->assertInstanceOf(HasOne::class, $r);
    }

    #[Test]
    public function answeredQuestions_relation(): void
    {
        $m = new User();

        $r = $m->answeredQuestions();

        $this->assertInstanceOf(BelongsToMany::class, $r);
    }

    #[Test]
    public function badges_relation(): void
    {
        $m = new User();

        $r = $m->badges();

        $this->assertInstanceOf(BelongsToMany::class, $r);
    }

    #[Test]
    public function points_relation(): void
    {
        $m = new User();

        $r = $m->points();

        $this->assertInstanceOf(HasMany::class, $r);
    }

    #[Test]
    public function accounts_relation(): void
    {
        $m = new User();

        $r = $m->accounts();

        $this->assertInstanceOf(HasMany::class, $r);
    }

    #[Test]
    #[DataProvider('provideTestCasesForUsername')]
    public function lowercase_username_when_set(
        string $input,
        string $want,
    ): void {
        $m = new User();

        $m->username = $input;

        $this->assertEquals($want, $m->getAttribute('username'));
    }

    public static function provideTestCasesForUsername(): Generator
    {
        yield 'User' => [
            'input' => 'User',
            'want' => 'user',
        ];

        yield 'ADMIN' => [
            'input' => 'ADMIN',
            'want' => 'admin',
        ];

        yield 'user' => [
            'input' => 'user',
            'want' => 'user',
        ];

        yield '12345' => [
            'input' => '12345',
            'want' => '12345',
        ];
    }

    #[Test]
    public function hashes_password_when_set(): void
    {
        Hash::shouldReceive('make')->once()->andReturn('hashed');

        $m = new User();
        $m->password = 'plain';

        $this->assertEquals('hashed', $m->password);
    }
}
