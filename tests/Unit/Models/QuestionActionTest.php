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

use Gamify\Enums\QuestionActuators;
use Gamify\Models\QuestionAction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class QuestionActionTest extends TestCase
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
            'when' => QuestionActuators::class,
        ], $m->getCasts());
    }

    public function test_question_relation()
    {
        $m = new QuestionAction();
        $r = $m->question();
        $this->assertInstanceOf(BelongsTo::class, $r);
    }
}
