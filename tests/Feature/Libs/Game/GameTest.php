<?php

namespace Tests\Feature\Libs\Game;

use Gamify\Badge;
use Gamify\Libs\Game\Game;
use Gamify\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function test_addReputation_method()
    {
        $user = factory(User::class)->create();

        $this->assertTrue(Game::addReputation($user, 5, 'test'));
        $this->assertEquals(5, $user->points()->sum('points'));
    }

    /** @test */
    public function it_increments_repetitions_for_a_given_badge()
    {
        $user = factory(User::class)->create();
        $badge = factory(Badge::class)->create([
            'required_repetitions' => 5,
        ]);

        Game::incrementBadge($user, $badge);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_increments_repetitions_for_a_given_badge_that_was_already_initiated()
    {
        $user = factory(User::class)->create();
        $badge = factory(Badge::class)->create([
            'required_repetitions' => 5,
        ]);
        Game::incrementBadge($user, $badge);

        Game::incrementBadge($user, $badge);

        $this->assertEquals(2, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_completes_badge_when_reach_required_repetitions()
    {
        $user = factory(User::class)->create();
        $badge = factory(Badge::class)->create([
            'required_repetitions' => 1,
        ]);

        Game::incrementBadge($user, $badge);

        $this->assertNotNull($user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->completed_on);
    }

    /** @test */
    public function it_does_not_complete_badge_when_required_repetitions_is_not_reached()
    {
        $user = factory(User::class)->create();
        $badge = factory(Badge::class)->create([
            'required_repetitions' => 5,
        ]);

        Game::incrementBadge($user, $badge);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->completed_on);
    }

    /** @test */
    public function it_does_not_update_repetitions_if_badge_was_already_completed()
    {
        $user = factory(User::class)->create();
        $badge = factory(Badge::class)->create([
            'required_repetitions' => 1,
        ]);
        Game::giveCompletedBadge($user, $badge);

        Game::incrementBadge($user, $badge);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_completes_a_badge_for_a_user()
    {
        $user = factory(User::class)->create();
        $badge = factory(Badge::class)->create();

        Game::giveCompletedBadge($user, $badge);

        $this->assertNotNull($user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->completed_on);
    }

    /** @test */
    public function it_completes_a_badge_when_a_user_had_already_started_it()
    {
        $user = factory(User::class)->create();
        $badge = factory(Badge::class)->create([
            'required_repetitions' => 5,
        ]);
        Game::incrementBadge($user, $badge); // Badge is started and not completed.

        Game::giveCompletedBadge($user, $badge);

        $this->assertNotNull($user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->completed_on);
    }

    public function test_getRanking_method()
    {
        factory(User::class, 10)->create();

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
        $users = factory(User::class, 5)->create();

        $got = Game::getRanking(5);

        foreach ($users as $item) {
            $this->assertTrue($got->contains('username', $item->username));
            $this->assertTrue($got->contains('name', $item->name));
        }
    }
}
