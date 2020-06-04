<?php

namespace Tests\Unit;

use Gamify\QuestionChoice;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\ModelTestCase;

class QuestionChoiceTest extends ModelTestCase
{
    public function test_contains_valid_fillable_properties()
    {
        $m = new QuestionChoice();
        $this->assertEquals([
            'text',
            'score',
        ], $m->getFillable());
    }

    public function test_contains_valid_casts_properties()
    {
        $m = new QuestionChoice();
        $this->assertEquals([
            'id' => 'int',
            'text' => 'string',
            'score' => 'int',
        ], $m->getCasts());
    }

    public function test_question_relation()
    {
        $m = new QuestionChoice();
        $r = $m->question();
        $this->assertInstanceOf(BelongsTo::class, $r);
    }

    /** @test */
    public function it_is_considered_correct_when_score_is_positive()
    {
        $m = new QuestionChoice();
        $m->score = 5;

        $this->assertTrue($m->isCorrect());
    }

    /** @test */
    public function it_is_considered_incorrect_when_score_is_zero()
    {
        $m = new QuestionChoice();
        $m->score = 0;

        $this->assertFalse($m->isCorrect());
    }

    /** @test */
    public function it_is_considered_incorrect_when_score_is_negative()
    {
        $m = new QuestionChoice();
        $m->score = -5;

        $this->assertFalse($m->isCorrect());
    }

    /**
     * @test
     * @deprecated
     */
    public function it_is_considered_correct_when_score_is_positive_using_deprecated_attribute()
    {
        $m = new QuestionChoice();
        $m->score = 5;

        $this->assertTrue($m->correct);
    }

    /**
     * @test
     * @deprecated
     */
    public function it_is_considered_incorrect_when_score_is_zero_using_deprecated_attribute()
    {
        $m = new QuestionChoice();
        $m->score = 0;

        $this->assertFalse($m->correct);
    }

    /**
     * @test
     * @deprecated
     */
    public function it_is_considered_incorrect_when_score_is_negative_using_deprecated_attribute()
    {
        $m = new QuestionChoice();
        $m->score = -5;

        $this->assertFalse($m->correct);
    }
}
