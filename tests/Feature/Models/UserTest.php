<?php

namespace Tests\Feature\Models;

use Gamify\Question;
use Gamify\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_pendingQuestions_returns_collection()
    {
        $u = factory(User::class)->create();

        factory(Question::class, 5)->create([
            'status' => Question::PUBLISH_STATUS,
        ]);

        $got = $u->pendingQuestions();

        $this->assertInstanceOf(Collection::class, $got);
    }

    public function test_pendingQuestions_with_limit()
    {
        $u = factory(User::class)->create();

        $limit = 2;
        factory(Question::class, $limit + 3)->create([
            'status' => Question::PUBLISH_STATUS,
        ]);

        $this->assertCount($limit, $u->pendingQuestions($limit));
    }

    public function test_addExperience_method()
    {
        $u = factory(User::class)->create();

        $want = 15;
        $u->addExperience($want);

        $this->assertEquals($want, $u->experience);
    }
}
