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
use Gamify\Enums\BadgeActuators;
use Gamify\Events\SocialLogin;
use Gamify\Events\ProfileUpdated;
use Gamify\Listeners\AddBadgesOnProfileUpdated;
use Gamify\Listeners\AddBadgesOnUserLoggedIn;
use Gamify\Models\Badge;
use Gamify\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\Feature\TestCase;

final class AddBadgesOnProfileUpdatedTest extends TestCase
{
    #[Test]
    public function it_should_listen_for_the_proper_events(): void
    {
        Event::fake();
        Event::assertListening(
            expectedEvent: ProfileUpdated::class,
            expectedListener: AddBadgesOnProfileUpdated::class
        );
    }

    #[Test]
    public function it_increments_badges_when_user_updates_profile(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnUserProfileUpdated->value,
        ]);

        /** @var ProfileUpdated $event */
        $event = Mockery::mock(ProfileUpdated::class);
        $event->user = $user;

        $listener = new AddBadgesOnProfileUpdated();
        $listener->handle($event);

        /** @phpstan-ignore-next-line */
        $this->assertEquals(1, $user->progressToCompleteTheBadge($badge)->repetitions);
    }

    #[Test]
    public function it_does_not_increment_badges_when_user_updates_profile(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::None->value,
        ]);

        /** @var ProfileUpdated $event */
        $event = Mockery::mock(ProfileUpdated::class);
        $event->user = $user;

        $listener = new AddBadgesOnProfileUpdated();
        $listener->handle($event);

        $this->assertNull($user->progressToCompleteTheBadge($badge));
    }
}
