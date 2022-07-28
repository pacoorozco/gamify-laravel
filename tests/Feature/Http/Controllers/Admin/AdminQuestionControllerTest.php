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

namespace Tests\Feature\Http\Controllers\Admin;

use Gamify\Http\Middleware\OnlyAjax;
use Gamify\Models\Question;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DataGenerator\QuestionDataGenerator;
use Tests\TestCase;

class AdminQuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        /** @var User $admin */
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);
    }

    /** @test */
    public function access_is_restricted_to_admins()
    {
        /** @var Question $question */
        $question = Question::factory()->create();

        $test_data = [
            ['protocol' => 'GET', 'route' => route('admin.questions.index')],
            ['protocol' => 'GET', 'route' => route('admin.questions.create')],
            ['protocol' => 'POST', 'route' => route('admin.questions.store')],
            ['protocol' => 'GET', 'route' => route('admin.questions.show', $question)],
            ['protocol' => 'GET', 'route' => route('admin.questions.edit', $question)],
            ['protocol' => 'PUT', 'route' => route('admin.questions.update', $question)],
            ['protocol' => 'DELETE', 'route' => route('admin.questions.destroy', $question)],
        ];

        /** @var User $user */
        $user = User::factory()->create();

        foreach ($test_data as $test) {
            $this->actingAs($user)
                ->call($test['protocol'], $test['route'])
                ->assertForbidden();
        }

        // Ajax routes needs to disable middleware
        $this->actingAs($user)
            ->withoutMiddleware(OnlyAjax::class)
            ->get(route('admin.questions.data'))
            ->assertForbidden();
    }

    /** @test */
    public function index_returns_proper_content()
    {
        $this->get(route('admin.questions.index'))
            ->assertOK()
            ->assertViewIs('admin.question.index');
    }

    /** @test */
    public function create_returns_proper_content()
    {
        $this->get(route('admin.questions.create'))
            ->assertOk()
            ->assertViewIs('admin.question.create');
    }

    /** @test */
    public function store_creates_an_object()
    {
        /** @var Question $question */
        $question = Question::factory()->make();
        $input_data = [
            'name' => $question->name,
            'question' => $question->question,
            'type' => $question->type,
            'hidden' => $question->hidden,
            'status' => $question->status,

            // Tags
            'tags' => [
                'tag_1',
                'tag_2',
                'tag_3',
            ],

            // Choices
            'choices' => [
                [
                    'text' => 'option_0_is_correct',
                    'score' => '5',
                ],
                [
                    'text' => 'option_1_is_incorrect',
                    'score' => '-5',
                ],
            ],
        ];

        $this->post(route('admin.questions.store'), $input_data)
            ->assertRedirect(route('admin.questions.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');

        $newQuestion = Question::where([
            'name' => $question->name,
            'question' => $question->question,
            'type' => $question->type,
            'hidden' => $question->hidden,
            'status' => $question->status,
        ])->first();

        $this->assertInstanceOf(Question::class, $newQuestion);
        $this->assertCount(3, $newQuestion->tags);
        $this->assertCount(2, $newQuestion->choices);
    }

    /** @test */
    public function store_returns_errors_on_invalid_data()
    {
        /** @var Question $want */
        $want = Question::factory()->make();
        $input_data = [
            'name' => $want->name,
        ];

        $this->post(route('admin.questions.store'), $input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');

        $this->assertDatabaseMissing(Question::class, [
            'name' => $want->name,
        ]);
    }

    /** @test */
    public function show_returns_proper_content()
    {
        /** @var Question $question */
        $question = Question::factory()->create();

        $this->get(route('admin.questions.show', $question))
            ->assertOk()
            ->assertViewIs('admin.question.show')
            ->assertSee($question->name);
    }

    /** @test */
    public function edit_returns_proper_content()
    {
        /** @var Question $question */
        $question = Question::factory()->create();

        $this->get(route('admin.questions.edit', $question))
            ->assertOk()
            ->assertViewIs('admin.question.edit')
            ->assertSee($question->name);
    }

    /** @test */
    public function update_edits_an_object()
    {
        /** @var Question $question */
        $question = Question::factory()->create([
            'name' => 'Question gold',
        ]);

        $input_data = [
            'name' => 'Question silver',
            'question' => $question->question,
            'type' => $question->type,
            'hidden' => $question->hidden,
            'status' => $question->status,

            // Tags
            'tags' => [
                'tag_1',
                'tag_2',
                'tag_3',
            ],

            // Choices
            'choices' => [
                [
                    'text' => 'option_0_is_correct',
                    'score' => '5',
                ],
                [
                    'text' => 'option_1_is_incorrect',
                    'score' => '-5',
                ],
            ],
        ];

        $this->put(route('admin.questions.update', $question), $input_data)
            ->assertRedirect(route('admin.questions.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');

        $question->refresh();

        $this->assertInstanceOf(Question::class, $question);
        $this->assertEquals('Question silver', $question->name);
        $this->assertCount(3, $question->tags);
        $this->assertCount(2, $question->choices);
    }

    /** @test */
    public function update_returns_errors_on_invalid_data()
    {
        /** @var Question $question */
        $question = Question::factory()->create([
            'name' => 'Question gold',
        ]);
        $input_data = QuestionDataGenerator::FormRequestData([
            'name' => '',
        ]);

        $this->put(route('admin.questions.update', $question), $input_data)
            ->assertSessionHasErrors()
            ->assertSessionHas('errors');

        $question->refresh();
        $this->assertEquals('Question gold', $question->name);
    }

    /** @test */
    public function destroy_deletes_an_object()
    {
        /** @var Question $question */
        $question = Question::factory()->create();

        $this->delete(route('admin.questions.destroy', $question))
            ->assertRedirect(route('admin.questions.index'))
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');

        $this->assertSoftDeleted($question);
    }
}
