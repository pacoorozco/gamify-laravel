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

namespace Tests\Unit\Models;

use Gamify\Models\QuestionChoice;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class QuestionChoiceTest extends TestCase
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
     *
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
     *
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
     *
     * @deprecated
     */
    public function it_is_considered_incorrect_when_score_is_negative_using_deprecated_attribute()
    {
        $m = new QuestionChoice();
        $m->score = -5;

        $this->assertFalse($m->correct);
    }
}
