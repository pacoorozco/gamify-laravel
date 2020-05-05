<?php

namespace Tests\Feature\Http\Controllers;

use Gamify\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_returns_proper_content()
    {
        $this->actingAsUser()
            ->get(route('questions.index'))
            ->assertOK()
            ->assertViewIs('question.index')
            ->assertViewHasAll([
                'questions',
                'next_level_name',
                'points_to_next_level',
                'percentage_to_next_level',
                'answered_questions',
                'percentage_of_answered_questions',
            ]);
    }

    /** @test */
    public function show_returns_proper_content()
    {
        $question = $this->createQuestionAsAdmin(1, [
            'status' => Question::PUBLISH_STATUS,
            'publication_date' => now(),
        ])->first();

        $this->actingAsUser()
            ->get(route('questions.show', $question->short_name))
            ->assertOk()
            ->assertViewIs('question.show')
            ->assertSee($question->name);
    }

    /** @test */
    public function answer_returns_proper_content()
    {
        $question = $this->createQuestionAsAdmin(1, [
            'status' => Question::PUBLISH_STATUS,
            'publication_date' => now(),
        ])->first();
        // Answer with the first choice.
        $input_data = [
            'choices' => [$question->choices()->first()->id],
        ];

        $this->actingAsUser()
            ->post(route('questions.answer', $question->short_name), $input_data)
            ->assertOk()
            ->assertViewIs('question.show-answered')
            ->assertViewHasAll([
                'answer',
                'question',
            ]);
    }
}
