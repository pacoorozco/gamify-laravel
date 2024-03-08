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

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\Test;
use Gamify\Models\Badge;
use Gamify\Models\User;
use Gamify\Notifications\BadgeUnlocked;
use Illuminate\Notifications\Notification;
use Tests\Feature\TestCase;

class MarkNotificationAsReadControllerTest extends TestCase
{
    #[Test]
    public function it_should_mark_a_notification_as_read(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        // Let's add two notifications.
        $user->notify(new BadgeUnlocked($badge));
        $user->notify(new BadgeUnlocked($badge));

        // We want to mark only one as read.
        /** @var Notification $notification */
        $notification = $user->unreadNotifications->first();

        $this
            ->actingAs($user)
            ->patch(route('notifications.read'), ['id' => $notification->id])
            ->assertNoContent();

        $this->assertCount(1, $user->refresh()->unreadNotifications);
    }

    #[Test]
    public function it_should_mark_all_notifications_as_read(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        // Let's add two notifications.
        $user->notify(new BadgeUnlocked($badge));
        $user->notify(new BadgeUnlocked($badge));

        $this
            ->actingAs($user)
            ->patch(route('notifications.read'))
            ->assertNoContent();

        $this->assertCount(0, $user->refresh()->unreadNotifications);
    }
}
