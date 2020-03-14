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

    public function test_addExperience_method()
    {
        $user = factory(User::class)->create();

        $this->assertTrue(Game::addExperience($user, 5, 'test'));
        $this->assertEquals(5, $user->points()->sum('points'));
    }

    public function test_incrementBadge_method()
    {
        $user = factory(User::class)->create();
        $badge = factory(Badge::class)->create([
            'required_repetitions' => 5,
        ]);

        $this->assertTrue(Game::incrementBadge($user, $badge));
    }

    public function test_addBadge_method()
    {
        $user = factory(User::class)->create();
        $badge = factory(Badge::class)->create([
            'required_repetitions' => 5,
        ]);

        $this->assertTrue(Game::addBadge($user, $badge));
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
