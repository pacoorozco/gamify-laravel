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

namespace Tests\Feature\Libs\Game;

use Gamify\Libs\Game\Game;
use Gamify\Models\Badge;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function test_addReputation_method()
    {
        $user = User::factory()->create();

        $this->assertTrue(Game::addReputation($user, 5, 'test'));
        $this->assertEquals(5, $user->points()->sum('points'));
    }

    /** @test */
    public function it_increments_repetitions_for_a_given_badge()
    {
        $user = User::factory()->create();
        $badge = Badge::factory()->create([
            'required_repetitions' => 5,
        ]);

        Game::incrementBadge($user, $badge);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_increments_repetitions_for_a_given_badge_that_was_already_initiated()
    {
        $user = User::factory()->create();
        $badge = Badge::factory()->create([
            'required_repetitions' => 5,
        ]);
        Game::incrementBadge($user, $badge);

        Game::incrementBadge($user, $badge);

        $this->assertEquals(2, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_completes_badge_when_reach_required_repetitions()
    {
        $user = User::factory()->create();
        $badge = Badge::factory()->create([
            'required_repetitions' => 1,
        ]);

        Game::incrementBadge($user, $badge);

        $this->assertNotNull($user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->completed_on);
    }

    /** @test */
    public function it_does_not_complete_badge_when_required_repetitions_is_not_reached()
    {
        $user = User::factory()->create();
        $badge = Badge::factory()->create([
            'required_repetitions' => 5,
        ]);

        Game::incrementBadge($user, $badge);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->completed_on);
    }

    /** @test */
    public function it_does_not_update_repetitions_if_badge_was_already_completed()
    {
        $user = User::factory()->create();
        $badge = Badge::factory()->create([
            'required_repetitions' => 1,
        ]);
        Game::giveCompletedBadge($user, $badge);

        Game::incrementBadge($user, $badge);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_completes_a_badge_for_a_user()
    {
        $user = User::factory()->create();
        $badge = Badge::factory()->create();

        Game::giveCompletedBadge($user, $badge);

        $this->assertNotNull($user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->completed_on);
    }

    /** @test */
    public function it_completes_a_badge_when_a_user_had_already_started_it()
    {
        $user = User::factory()->create();
        $badge = Badge::factory()->create([
            'required_repetitions' => 5,
        ]);
        Game::incrementBadge($user, $badge); // Badge is started and not completed.

        Game::giveCompletedBadge($user, $badge);

        $this->assertNotNull($user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->completed_on);
    }

    /** @test */
    public function getRanking_method_returns_data()
    {
        User::factory()->count(10)->create();

        $test_data = [
            ['input' => 5, 'output' => 5],
            ['input' => 10, 'output' => 10],
            ['input' => 11, 'output' => 10],
        ];

        foreach ($test_data as $test) {
            $got = Game::getRanking($test['input']);

            $this->assertInstanceOf(Collection::class, $got);
            $this->assertCount(
                $test['output'], $got,
                sprintf("Test case: input='%d', want='%d'", $test['input'], $test['output']));
        }
    }

    public function test_getRanking_returns_proper_content()
    {
        $users = User::factory()->count(5)->create();

        $got = Game::getRanking(5);

        foreach ($users as $item) {
            $this->assertTrue($got->contains('username', $item->username));
            $this->assertTrue($got->contains('name', $item->name));
        }
    }
}
