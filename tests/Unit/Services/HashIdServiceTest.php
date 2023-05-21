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

namespace Tests\Unit\Services;

use Gamify\Services\HashIdService;
use Tests\TestCase;

class HashIdServiceTest extends TestCase
{
    /** @test */
    public function it_should_get_the_same_number_after_encoding_it_and_decoding_it(): void
    {
        $input = fake()->randomNumber();

        $s = new HashIdService();
        $hash = $s->encode($input);

        $this->assertEquals($input, $s->decode($hash));
    }

    /** @test */
    public function it_should_return_the_hash_of_the_input(): void
    {
        $number = fake()->randomNumber();

        $s = new HashIdService();

        $this->assertNotEquals($number, $s->encode($number));
    }

    /** @test */
    public function it_should_return_the_same_if_input_is_not_a_hash(): void
    {
        $number = fake()->randomNumber();

        $s = new HashIdService();

        $this->assertEquals($number, $s->decode($number));
    }
}
