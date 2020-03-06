<?php

namespace Tests\Feature\Models;

use Gamify\Question;
use Gamify\QuestionAction;
use Gamify\QuestionChoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_scopePublished_returns_correct_data()
    {
        // three non-published Questions
        factory(Question::class, 3)->create([
            'status' => Question::DRAFT_STATUS,
        ]);

        // two published Questions
        factory(Question::class, 2)->create([
            'status' => Question::PUBLISH_STATUS,
        ]);

        $got = Question::published()->get();

        $this->assertCount(2, $got);
    }

    public function test_scopeVisible_returns_correct_data()
    {
        // this questions should not be shown
        factory(Question::class, 3)->create([
            'status' => Question::PUBLISH_STATUS,
            'hidden' => true,
        ]);

        // this questions should be shown
        factory(Question::class, 2)->create([
            'status' => Question::PUBLISH_STATUS,
            'hidden' => false,
        ]);

        $got = Question::visible()->get();

        $this->assertCount(2, $got);
    }
}
