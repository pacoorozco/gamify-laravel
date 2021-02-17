<?php

namespace Tests\Feature\Listeners;

use Gamify\Models\Badge;
use Gamify\Enums\BadgeActuators;
use Gamify\Enums\QuestionActuators;
use Gamify\Events\QuestionAnswered;
use Gamify\Listeners\IncrementBadgesOnQuestionAnswered;
use Gamify\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncrementBadgeOnQuestionAnsweredTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_increments_badges_with_OnQuestionAnswered_actuator()
    {
        $user = $this->user();
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnQuestionAnswered,
        ]);
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_does_not_increment_badges_without_OnQuestionAnswered_actuator()
    {
        $user = $this->user();
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::None,
        ]);
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }

    /** @test */
    public function it_increments_badges_with_OnQuestionCorrectlyAnswered_actuator_when_answer_is_correct()
    {
        $user = $this->user();
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered,
        ]);
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_increments_badges_with_OnQuestionIncorrectlyAnswered_actuator_when_answer_is_incorrect()
    {
        $user = $this->user();
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered,
        ]);
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = false;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_does_not_increment_badges_with_OnQuestionCorrectlyAnswered_actuator_when_answer_is_incorrect()
    {
        $user = $this->user();
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered,
        ]);
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = false;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }

    /** @test */
    public function it_does_not_increment_badges_with_OnQuestionIncorrectlyAnswered_actuator_when_answer_is_correct()
    {
        $user = $this->user();
        $badge = Badge::factory()->create([
            'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered,
        ]);
        $question = Question::factory()->create();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }

    /** @test */
    public function it_increments_badges_with_OnQuestionIncorrectlyAnswered_actuator_associated_to_a_question_when_answer_is_incorrect()
    {
        $badge = Badge::factory()->create();
        $question = Question::factory()->create();
        $question->actions()->create([
            'when' => QuestionActuators::OnQuestionIncorrectlyAnswered,
            'badge_id' => $badge->id,
        ]);

        $user = $this->user();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = false;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_increments_badges_with_OnQuestionIncorrectlyAnswered_actuator_associated_to_a_question_when_answer_is_correct()
    {
        $badge = Badge::factory()->create();
        $question = Question::factory()->create();
        $question->actions()->create([
            'when' => QuestionActuators::OnQuestionIncorrectlyAnswered,
            'badge_id' => $badge->id,
        ]);

        $user = $this->user();

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->question = $question;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }
}
