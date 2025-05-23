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

use PHPUnit\Framework\Attributes\Test;
use Gamify\Enums\BadgeActuators;
use Gamify\Models\Badge;
use Tests\Feature\TestCase;

final class BadgeTest extends TestCase
{
    #[Test]
    public function it_should_return_the_default_image_if_badge_has_not_image(): void
    {
        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        $this->assertEquals('/images/missing_badge.png', $badge->image);
    }

    #[Test]
    public function it_should_return_only_active_badges(): void
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

    #[Test]
    public function it_should_return_only_active_badges_with_the_specified_actuators(): void
    {
        Badge::factory()
            ->inactive()
            ->create([
                'actuators' => BadgeActuators::OnQuestionAnswered->value,
            ]);

        $want = Badge::factory()
            ->active()
            ->count(2)
            ->create([
                'actuators' => BadgeActuators::OnUserLoggedIn->value,
            ]);

        $badges = Badge::query()
            ->withActuatorsIn([
                BadgeActuators::OnUserLoggedIn->value,
            ])
            ->get();

        $this->assertEquals($want->pluck('name'), $badges->pluck('name'));
    }

    #[Test]
    public function it_should_return_only_active_badges_with_the_question_actuators_and_specified_tags(): void
    {
        // active but without tags
        Badge::factory()
            ->active()
            ->create([
                'actuators' => BadgeActuators::OnQuestionAnswered->value,
            ]);

        // active and with one matching tag: 'tag1'
        $want = Badge::factory()
            ->active()
            ->count(2)
            ->create([
                'actuators' => BadgeActuators::OnQuestionAnswered->value,
            ]);

        $want->each(function ($badge): void {
            /** @var Badge $badge */
            $badge->tag(['tag1', 'foo']);
        });

        $got = Badge::triggeredByQuestionsWithTagsIn(['tag1', 'bar']);

        $this->assertEquals($want->count(), $got->count());

        $this->assertEquals($want->pluck('name'), $got->pluck('name'));
    }
}
