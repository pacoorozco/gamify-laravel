<?php

namespace Tests\Feature\Http\Controllers;

use Gamify\Events\QuestionAnswered;
use Gamify\Models\Question;
use Gamify\Models\QuestionChoice;
use Gamify\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class QuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    private Question $question;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        /** @var User $admin */
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);
        $this->question = Question::factory()
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create([
                'status' => Question::PUBLISH_STATUS,
                'publication_date' => now(),
            ]);

        $this->user = User::factory()->create();
    }

    /** @test */
    public function index_returns_proper_content()
    {
        $this->actingAs($this->user)
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
        $this->actingAs($this->user)
            ->get(route('questions.show', $this->question->short_name))
            ->assertOk()
            ->assertViewIs('question.show')
            ->assertSee($this->question->name);
    }

    /** @test */
    public function answer_returns_proper_content()
    {
        // Answer with the first choice.
        $input_data = [
            'choices' => [$this->question->choices()->first()->id],
        ];

        $this->actingAs($this->user)
            ->post(route('questions.answer', $this->question->short_name), $input_data)
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
        // Answer with the correct choice.
        $input_data = [
            'choices' => [$this->question->choices()->correct()->first()->id],
        ];

        Event::fake();

        $this->actingAs($this->user)
            ->post(route('questions.answer', $this->question->short_name), $input_data)
            ->assertOk();

        $question = $this->question;
        Event::assertDispatched(QuestionAnswered::class, function ($e) use ($question) {
            return $e->question->id === $question->id &&
                $e->correctness === true;
        });
    }

    /** @test */
    public function it_fires_an_event_when_question_is_answered_incorrectly()
    {
        // Answer with the incorrect choice.
        $input_data = [
            'choices' => [$this->question->choices()->incorrect()->first()->id],
        ];

        Event::fake();

        $this->actingAs($this->user)
            ->post(route('questions.answer', $this->question->short_name), $input_data)
            ->assertOk();

        $question = $this->question;
        Event::assertDispatched(QuestionAnswered::class, function ($e) use ($question) {
            return $e->question->id === $question->id &&
                $e->correctness === false;
        });
    }
}
