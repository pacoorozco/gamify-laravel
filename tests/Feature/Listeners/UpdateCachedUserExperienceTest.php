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

namespace Tests\Feature\Listeners;

use PHPUnit\Framework\Attributes\Test;
use Gamify\Events\PointCreated;
use Gamify\Events\PointDeleted;
use Gamify\Listeners\UpdateCachedUserExperience;
use Gamify\Models\Point;
use Gamify\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\Feature\TestCase;

final class UpdateCachedUserExperienceTest extends TestCase
{
    #[Test]
    public function it_should_listen_for_the_proper_event(): void
    {
        Event::fake();
        Event::assertListening(
            expectedEvent: PointCreated::class,
            expectedListener: UpdateCachedUserExperience::class
        );
        Event::assertListening(
            expectedEvent: PointDeleted::class,
            expectedListener: UpdateCachedUserExperience::class
        );
    }

    #[Test]
    public function it_updates_the_cached_value_on_point_creation(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        Point::factory()
            ->for($user)
            ->create([
                'points' => 5,
            ]);

        $this->assertEquals(5, $user->experience);
    }

    #[Test]
    public function it_updates_the_cached_value_on_point_deletion(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $point = Point::factory()
            ->for($user)
            ->create([
                'points' => 5,
            ]);

        $this->assertEquals(5, $user->experience);

        $point->delete();

        $this->assertEquals(0, $user->experience);
    }
}
