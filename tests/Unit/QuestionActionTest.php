<?php

namespace Tests\Unit;

use Gamify\QuestionAction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\ModelTestCase;

class QuestionActionTest extends ModelTestCase
{
    public function test_contains_valid_fillable_properties()
    {
        $m = new QuestionAction();
        $this->assertEquals([
            'when',
            'badge_id',
        ], $m->getFillable());
    }

    public function test_contains_valid_casts_properties()
    {
        $m = new QuestionAction();
        $this->assertEquals([
            'id' => 'int',
            'when' => 'string',
            'badge_id' => 'int',
        ], $m->getCasts());
    }

    public function test_question_relation()
    {
        $m = new QuestionAction();
        $r = $m->question();
        $this->assertInstanceOf(BelongsTo::class, $r);
    }
}
