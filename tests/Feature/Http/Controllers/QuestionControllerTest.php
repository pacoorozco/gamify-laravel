<?php

namespace Tests\Feature\Http\Controllers;

use Gamify\Events\QuestionAnswered;
use Gamify\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
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
        $this->actingAsAdmin();
        $question = Question::factory()
            ->states('with_choices')
            ->create([
                'status' => Question::PUBLISH_STATUS,
                'publication_date' => now(),
            ]);

        $this->actingAsUser()
            ->get(route('questions.show', $question->short_name))
            ->assertOk()
            ->assertViewIs('question.show')
            ->assertSee($question->name);
    }

    /** @test */
    public function answer_returns_proper_content()
    {
        $this->actingAsAdmin();
        $question = Question::factory()
            ->states('with_choices')
            ->create([
                'status' => Question::PUBLISH_STATUS,
                'publication_date' => now(),
            ]);

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

    /** @test */
    public function it_fires_an_event_when_question_is_answered_correctly()
    {
        $this->actingAsAdmin();
        $question = Question::factory()
            ->states('with_choices')
            ->create([
                'status' => Question::PUBLISH_STATUS,
                'publication_date' => now(),
            ]);

        // Answer with the correct choice.
        $input_data = [
            'choices' => [$question->choices()->correct()->first()->id],
        ];

        Event::fake();

        $this->actingAsUser()
            ->post(route('questions.answer', $question->short_name), $input_data)
            ->assertOk();

        Event::assertDispatched(QuestionAnswered::class, function ($e) use ($question) {
            return $e->question->id === $question->id &&
                $e->correctness === true;
        });
    }

    /** @test */
    public function it_fires_an_event_when_question_is_answered_incorrectly()
    {
        $this->actingAsAdmin();
        $question = Question::factory()
            ->states('with_choices')
            ->create([
                'status' => Question::PUBLISH_STATUS,
                'publication_date' => now(),
            ]);

        // Answer with the incorrect choice.
        $input_data = [
            'choices' => [$question->choices()->incorrect()->first()->id],
        ];

        Event::fake();

        $this->actingAsUser()
            ->post(route('questions.answer', $question->short_name), $input_data)
            ->assertOk();

        Event::assertDispatched(QuestionAnswered::class, function ($e) use ($question) {
            return $e->question->id === $question->id &&
                $e->correctness === false;
        });
    }
}
