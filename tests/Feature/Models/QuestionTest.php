<?php

namespace Tests\Feature\Models;

use Gamify\Badge;
use Gamify\Events\QuestionPublished;
use Gamify\Exceptions\InvalidContentForPublicationException;
use Gamify\Question;
use Gamify\QuestionAction;
use Gamify\QuestionChoice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_scopePublished_returns_correct_data()
    {
        // three non-published Questions
        factory(Question::class, 3)->create([
            'status' => Question::DRAFT_STATUS,
        ]);

        // two published Questions
        factory(Question::class, 2)->create([
            'status' => Question::PUBLISH_STATUS,
        ]);

        $got = Question::published()->get();

        $this->assertCount(2, $got);
    }

    public function test_scopeVisible_returns_correct_data()
    {
        // this questions should not be shown
        factory(Question::class, 3)->create([
            'status' => Question::PUBLISH_STATUS,
            'hidden' => true,
        ]);

        // this questions should be shown
        factory(Question::class, 2)->create([
            'status' => Question::PUBLISH_STATUS,
            'hidden' => false,
        ]);

        $got = Question::visible()->get();

        $this->assertCount(2, $got);
    }

    public function test_getActionableBadgesForCorrectness_method()
    {
        $question = factory(Question::class)->create();
        $badge = factory(Badge::class)->create();

        $question->actions()->create([
            'when' => QuestionAction::ON_ANY_CASE,
            'badge_id' => $badge->id,
        ]);

        $got = $question->getActionableBadgesForCorrectness(true);

        $this->assertInstanceOf(Collection::class, $got);
        $this->assertCount(1, $got);
    }

    /** @test */
    public function it_returns_true_when_question_can_be_published()
    {
        $question = factory(Question::class)->state('with_choices')->create();

        $this->assertTrue($question->canBePublished());
    }

    /** @test */
    public function it_returns_false_when_question_can_not_be_published()
    {
        $question = factory(Question::class)->create();

        $this->assertFalse($question->canBePublished());
    }

    /** @test */
    public function it_triggers_an_event_when_a_question_is_published()
    {
        $question = factory(Question::class)->state('with_choices')->create();
        Event::fake(); // should be fake after question creation

        $question->publish();

        Event::assertDispatched(QuestionPublished::class);
    }

    /** @test */
    public function it_does_not_trigger_an_event_when_a_question_was_already_published()
    {
        $question = factory(Question::class)->state('with_choices')->create([
            'status' => Question::PUBLISH_STATUS,
        ]);
        Event::fake(); // should be fake after question creation

        $question->publish();

        Event::assertNotDispatched(QuestionPublished::class);
    }

    /** @test */
    public function it_does_not_trigger_an_event_when_a_question_is_scheduled()
    {
        $question = factory(Question::class)->state('with_choices')->create([
            'publication_date' => now()->addWeek(),
        ]);
        Event::fake(); // should be fake after question creation

        $question->publish();

        Event::assertNotDispatched(QuestionPublished::class);
    }

    /** @test */
    public function it_throws_an_exception_when_trying_to_publish_a_question_without_at_least_two_choices()
    {
        $this->withoutExceptionHandling();
        $question = factory(Question::class)->create();
        $question->choices()->save(
            new QuestionChoice([
                'text' => 'answer',
                'correct' => true,
                'score' => 5,
            ])
        );

        $this->expectException(InvalidContentForPublicationException::class);

        $question->publish();
    }

    /** @test */
    public function it_throws_an_exception_when_trying_to_publish_a_question_without_a_correct_choice()
    {
        $this->withoutExceptionHandling();
        $question = factory(Question::class)->create();
        $question->choices()->saveMany([
            new QuestionChoice([
                'text' => 'answer 1',
                'correct' => false,
                'score' => -5,
            ]),
            new QuestionChoice([
                'text' => 'answer 2',
                'correct' => false,
                'score' => -5,
            ])
        ]);

        $this->expectException(InvalidContentForPublicationException::class);

        $question->publish();
    }

    /** @test */
    public function it_publishes_question_when_date_is_on_the_past()
    {
        $question = factory(Question::class)->state('with_choices')->create([
            'publication_date' => now()->subWeek(),
        ]);
        $question->publish();

        $this->assertEquals(Question::PUBLISH_STATUS, $question->status);
    }

    /** @test */
    public function it_schedules_question_publication_when_date_is_in_the_future()
    {
        $question = factory(Question::class)->state('with_choices')->create([
            'publication_date' => now()->addWeek(),
        ]);
        $question->publish();

        $this->assertEquals(Question::FUTURE_STATUS, $question->status);
    }

    /** @test */
    public function it_does_not_trigger_an_event_when_publish_fails()
    {
        $question = factory(Question::class)->create();
        $question->choices()->save(
            new QuestionChoice([
                'text' => 'answer',
                'correct' => true,
                'score' => 5,
            ])
        );
        Event::fake(); // should be fake after question creation

        try {
            $question->publish();
        } catch (\Exception $exception) {
            // catch exception to make the test not fail by this reason
        }

        Event::assertNotDispatched(QuestionPublished::class);
    }
}
