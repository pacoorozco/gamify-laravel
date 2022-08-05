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

use Gamify\Models\Question;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    public function test_contains_valid_fillable_properties(): void
    {
        $m = new Question();
        $this->assertEquals([
            'name',
            'question',
            'solution',
            'type',
            'hidden',
            'publication_date',
        ], $m->getFillable());
    }

    public function test_contains_valid_casts_properties(): void
    {
        $m = new Question();
        $this->assertEquals([
            'id' => 'int',
            'hidden' => 'bool',
            'publication_date' => 'datetime',
            'expiration_date' => 'datetime',
            'deleted_at' => 'datetime',
        ], $m->getCasts());
    }

    public function test_contains_valid_sluggable_configuration(): void
    {
        $m = new Question();
        $this->assertEquals([
            'short_name' => [
                'source' => 'name',
            ],
        ], $m->sluggable());
    }

    public function test_choices_relation(): void
    {
        $m = new Question();
        $r = $m->choices();
        $this->assertInstanceOf(HasMany::class, $r);
    }

    public function test_excerpt_method(): void
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
