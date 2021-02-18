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

namespace Tests\Feature\Models;

use Gamify\Enums\BadgeActuators;
use Gamify\Models\Badge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BadgeTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_default_image_when_field_is_empty()
    {
        $badge = Badge::factory()->create();

        $this->assertNull($badge->getOriginal('image_url'));
    }

    /** @test */
    public function it_returns_actuators_as_enum_when_model_is_read_from_database()
    {
        $want = Badge::factory()->create();
        $want->actuators = BadgeActuators::OnUserLogin();
        $want->saveOrFail();

        $got = Badge::find($want)->first();

        $this->assertEquals(BadgeActuators::OnUserLogin(), $got->actuators);
    }
}
