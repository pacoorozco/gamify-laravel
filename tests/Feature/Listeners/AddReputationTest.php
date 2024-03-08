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
use Gamify\Events\QuestionAnswered;
use Gamify\Listeners\AddReputation;
use Gamify\Models\Question;
use Gamify\Models\User;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\Feature\TestCase;

class AddReputationTest extends TestCase
{
    #[Test]
    public function it_should_listen_for_the_proper_event(): void
    {
        Event::fake();
        Event::assertListening(
            expectedEvent: QuestionAnswered::class,
            expectedListener: AddReputation::class
        );
    }

    #[Test]
    public function it_increments_the_user_experience(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Question $question */
        $question = Question::factory()
            ->published()
            ->create();

        /** @var QuestionAnswered $event */
        $event = Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->points = 5;
        $event->correctness = true;

        $listener = new AddReputation();
        $listener->handle($event);

        $this->assertEquals(5, $user->experience);
    }
}
