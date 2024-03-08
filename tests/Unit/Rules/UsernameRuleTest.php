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

namespace Tests\Unit\Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Gamify\Rules\UsernameRule;
use Generator;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UsernameRuleTest extends TestCase
{
    #[Test]
    #[DataProvider('providesWrongUsernames')]
    public function it_should_fail_with_wrong_usernames(
        string $input
    ): void {
        $validator = Validator::make(
            ['username' => $input],
            ['username' => new UsernameRule()]
        );

        $this->assertTrue($validator->fails());
    }

    public static function providesWrongUsernames(): Generator
    {
        yield 'empty input' => [
            'input' => '',
        ];

        yield 'input with white spaces' => [
            'input' => 'foo bar',
        ];

        yield 'input > 255 chars' => [
            'input' => '0123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345',
        ];

        yield 'input contains invalid characters' => [
            'input' => 'u$ern4me',
        ];

        yield 'input begins with a hyphen' => [
            'input' => '-foo',
        ];
    }

    #[Test]
    #[DataProvider('providesValidUsernames')]
    public function it_should_pass_valid_usernames(
        string $input
    ): void {
        $validator = Validator::make(
            ['username' => $input],
            ['username' => new UsernameRule()]
        );

        $this->assertTrue($validator->passes());
    }

    public static function providesValidUsernames(): Generator
    {
        yield 'input lowercase' => [
            'input' => 'foo',
        ];

        yield 'input uppercase' => [
            'input' => 'FOO',
        ];

        yield 'input mixed case' => [
            'input' => 'FooBar',
        ];

        yield 'input contains numbers' => [
            'input' => 'Fo0Bar3',
        ];

        yield 'input contains the dot char' => [
            'input' => 'Foo.Bar',
        ];

        yield 'input contains the underscore char' => [
            'input' => 'Foo_Bar',
        ];
    }
}
