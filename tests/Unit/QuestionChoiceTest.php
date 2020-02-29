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
            'correct',
            'score',
        ], $m->getFillable());
    }

    public function test_contains_valid_casts_properties()
    {
        $m = new QuestionChoice();
        $this->assertEquals([
            'id' => 'int',
            'text' => 'string',
            'correct' => 'bool',
            'score' => 'int',
        ], $m->getCasts());
    }

    public function test_question_relation()
    {
        $m = new QuestionChoice();
        $r = $m->question();
        $this->assertInstanceOf(BelongsTo::class, $r);
    }
}
