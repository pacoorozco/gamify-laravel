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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Gamify\Http\Middleware\OnlyAjax;
use Gamify\Models\Question;
use Gamify\Models\User;
use Tests\DataGenerator\QuestionDataGenerator;
use Tests\Feature\TestCase;

final class AdminQuestionControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $admin */
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);
    }

    #[Test]
    public function access_is_restricted_to_admins(): void
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

    #[Test]
    public function index_returns_proper_content(): void
    {
        $this->get(route('admin.questions.index'))
            ->assertOK()
            ->assertViewIs('admin.question.index');
    }

    #[Test]
    public function create_returns_proper_content(): void
    {
        $this->get(route('admin.questions.create'))
            ->assertOk()
            ->assertViewIs('admin.question.create');
    }

    #[Test]
    public function store_creates_an_object(): void
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

        /** @var Question $newQuestion */
        $newQuestion = Question::where([
            'name' => $question->name,
            'question' => $question->question,
            'type' => $question->type,
            'hidden' => $question->hidden,
            'status' => $question->status,
        ])->first();

        $this->assertInstanceOf(Question::class, $newQuestion);

        $this->assertEquals($input_data['tags'], $newQuestion->tagArray);

        $this->assertCount(2, $newQuestion->choices);
    }

    #[Test]
    public function store_returns_errors_on_invalid_data(): void
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

    #[Test]
    public function show_returns_proper_content(): void
    {
        /** @var Question $question */
        $question = Question::factory()->create();

        $this->get(route('admin.questions.show', $question))
            ->assertOk()
            ->assertViewIs('admin.question.show')
            ->assertSee($question->name);
    }

    #[Test]
    public function edit_returns_proper_content(): void
    {
        /** @var Question $question */
        $question = Question::factory()->create();

        $this->get(route('admin.questions.edit', $question))
            ->assertOk()
            ->assertViewIs('admin.question.edit')
            ->assertSee($question->name);
    }

    #[Test]
    #[DataProvider('providesTestCasesForEdition')]
    public function update_edits_an_object(
        array $want
    ): void {
        /** @var Question $question */
        $question = Question::factory()->create([
            'name' => 'Question gold',
        ]);
        $question->tag(['tag1', 'tag2']);

        $input_data = [
            'name' => 'Question silver',
            'question' => $question->question,
            'type' => $question->type,
            'hidden' => $question->hidden,
            'status' => $question->status,

            // Tags
            'tags' => $want['tags'],

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
        $this->assertEquals($want['tags'], $question->tagArray);
        $this->assertCount(2, $question->choices);
    }

    public static function providesTestCasesForEdition(): \Generator
    {
        yield 'tags are changed' => [
            'want' => [
                'tags' => ['foo', 'bar'],
            ],
        ];

        yield 'tags are removed' => [
            'want' => [
                'tags' => [],
            ],
        ];
    }

    #[Test]
    public function update_returns_errors_on_invalid_data(): void
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

    #[Test]
    public function destroy_deletes_an_object(): void
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
