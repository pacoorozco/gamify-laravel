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

namespace Tests\Feature\Http\Console\Commands;

use Gamify\Console\Commands\PublishScheduledQuestions;
use Gamify\Models\Question;
use Gamify\Models\QuestionChoice;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublishScheduledQuestionsTest extends TestCase
{
    use RefreshDatabase;

    private Question $questionScheduledOnThePast;

    private Question $questionScheduledOnTheFuture;

    public function setUp(): void
    {
        parent::setUp();

        /** @var User $admin */
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        $this->questionScheduledOnThePast = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create([
                'status' => Question::FUTURE_STATUS,
                'publication_date' => now()->subDay(),
            ]);

        $this->questionScheduledOnTheFuture = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create([
                'status' => Question::FUTURE_STATUS,
                'publication_date' => now()->addDay(),
            ]);
    }

    /** @test */
    public function onlyPublishQuestionsScheduledOnThePast()
    {
        \Artisan::call(PublishScheduledQuestions::class);

        $this->assertTrue(Question::findOrFail($this->questionScheduledOnThePast->id)->isPublished());
        $this->assertFalse(Question::findOrFail($this->questionScheduledOnTheFuture->id)->isPublished());
    }
}
