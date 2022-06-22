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

    /** @test */
    public function it_should_return_the_default_image_if_badge_has_not_image()
    {
        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        $this->assertNull($badge->getOriginal('image_url'));

        $this->assertEquals(Badge::DEFAULT_IMAGE, $badge->image);
    }

    /** @test */
    public function it_should_return_only_active_badges()
    {
        Badge::factory()
            ->inactive()
            ->count(3)
            ->create();

        $want = Badge::factory()
            ->active()
            ->count(2)
            ->create();

        $this->assertEquals($want->pluck('name'), Badge::active()->pluck('name'));
    }

    /** @test */
    public function it_should_return_only_active_badges_with_the_specified_actuators()
    {
        Badge::factory()
            ->inactive()
            ->withActuators([BadgeActuators::OnUserLogin])
            ->create();

        $want = Badge::factory()
            ->active()
            ->withActuators([
                BadgeActuators::OnUserLogin,
                BadgeActuators::OnQuestionAnswered,
            ])
            ->count(2)
            ->create();

        $badges = Badge::query()
            ->withActuatorsIn([
                BadgeActuators::OnUserLogin,
            ])
            ->get();

        $this->assertEquals($want->pluck('name'), $badges->pluck('name'));
    }
}
