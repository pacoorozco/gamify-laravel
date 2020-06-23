<?php

namespace Tests\Feature\Listeners;

use Gamify\Badge;
use Gamify\Enums\BadgeActuators;
use Gamify\Events\QuestionAnswered;
use Gamify\Listeners\IncrementBadgesOnQuestionAnswered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncrementBadgeOnQuestionAnsweredTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_increments_badges_with_OnQuestionAnswered_actuator()
    {
        $user = $this->user();
        $badge = factory(Badge::class)->create([
            'actuators' => BadgeActuators::OnQuestionAnswered,
        ]);

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_does_not_increment_badges_without_OnQuestionAnswered_actuator()
    {
        $user = $this->user();
        $badge = factory(Badge::class)->create([
            'actuators' => BadgeActuators::None,
        ]);

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }

    /** @test */
    public function it_increments_badges_with_OnQuestionCorrectlyAnswered_actuator_when_answer_is_correct()
    {
        $user = $this->user();
        $badge = factory(Badge::class)->create([
            'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered,
        ]);

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_increments_badges_with_OnQuestionIncorrectlyAnswered_actuator_when_answer_is_incorrect()
    {
        $user = $this->user();
        $badge = factory(Badge::class)->create([
            'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered,
        ]);

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->correctness = false;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertEquals(1, $user->badges()->wherePivot('badge_id', $badge->id)->first()->pivot->repetitions);
    }

    /** @test */
    public function it_does_not_increment_badges_with_OnQuestionCorrectlyAnswered_actuator_when_answer_is_incorrect()
    {
        $user = $this->user();
        $badge = factory(Badge::class)->create([
            'actuators' => BadgeActuators::OnQuestionCorrectlyAnswered,
        ]);

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->correctness = false;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }

    /** @test */
    public function it_does_not_increment_badges_with_OnQuestionIncorrectlyAnswered_actuator_when_answer_is_correct()
    {
        $user = $this->user();
        $badge = factory(Badge::class)->create([
            'actuators' => BadgeActuators::OnQuestionIncorrectlyAnswered,
        ]);

        $event = \Mockery::mock(QuestionAnswered::class);
        $event->user = $user;
        $event->correctness = true;

        $listener = app()->make(IncrementBadgesOnQuestionAnswered::class);
        $listener->handle($event);

        $this->assertNull($user->badges()->wherePivot('badge_id', $badge->id)->first());
    }
}
