<?php

namespace Tests\Unit;

use Gamify\Question;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\ModelTestCase;

class QuestionTest extends ModelTestCase
{
    public function test_contains_valid_fillable_properties()
    {
        $m = new Question();
        $this->assertEquals([
            'name',
            'question',
            'solution',
            'type',
            'hidden',
            'status',
        ], $m->getFillable());
    }

    public function test_contains_valid_casts_properties()
    {
        $m = new Question();
        $this->assertEquals([
            'id' => 'int',
            'name' => 'string',
            'short_name' => 'string',
            'question' => 'string',
            'solution' => 'string',
            'type' => 'string',
            'hidden' => 'bool',
            'status' => 'string',
        ], $m->getCasts());
    }

    public function test_contains_valid_sluggable_configuration()
    {
        $m = new Question();
        $this->assertEquals([
            'short_name' => [
                'source' => 'name',
            ],
        ], $m->sluggable());
    }

    public function test_actions_relation()
    {
        $m = new Question();
        $r = $m->actions();
        $this->assertInstanceOf(HasMany::class, $r);
    }

    public function test_choices_relation()
    {
        $m = new Question();
        $r = $m->choices();
        $this->assertInstanceOf(HasMany::class, $r);
    }

    public function test_excerpt_method()
    {
        $m = new Question();

        $m->question = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis suscipit tortor sed egestas volutpat. Morbi.';

        $test_data = [
            20 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis suscipit tortor sed egestas volutpat. Morbi.',
            15 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis suscipit tortor sed egestas volutpat. Morbi.',
            14 => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis suscipit tortor sed egestas volutpat....',
            3 => 'Lorem ipsum dolor...',
            0 => '',
        ];

        foreach ($test_data as $words => $want) {
            $this->assertEquals($want, $m->excerpt($words), 'Test case: '.$words.' words.');
        }
    }
}
