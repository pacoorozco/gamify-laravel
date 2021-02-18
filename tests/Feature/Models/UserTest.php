<?php

namespace Tests\Feature\Models;

use Gamify\Models\Badge;
use Gamify\Models\Question;
use Gamify\Models\QuestionChoice;
use Gamify\Models\User;
use Gamify\Models\UserProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pendingQuestions_returns_a_collection()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->pendingQuestions());
    }

    /** @test */
    public function pendingQuestions_returns_specified_number_of_questions()
    {
        // Creates 5 published questions.
        /** @var User $admin */
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);
        Question::factory()
            ->count(5)
            ->has(QuestionChoice::factory()->correct(), 'choices')
            ->has(QuestionChoice::factory()->incorrect(), 'choices')
            ->create([
                'status' => Question::PUBLISH_STATUS,
                'publication_date' => now(),
            ]);

        /** @var User $user */
        $user = User::factory()->create();

        // We only want 3 of the 5 created questions.
        $this->assertCount(3, $user->pendingQuestions(3));
    }

    /** @test */
    public function pendingQuestions_returns_zero_when_no_questions()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertCount(0, $user->pendingQuestions());
    }

    /** @test */
    public function addExperience_method()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $want = 15;
        $user->addExperience($want);

        $this->assertEquals($want, $user->experience);
    }

    /** @test */
    public function returns_default_image_when_avatar_is_empty()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertNull($user->profile->avatar);
        $this->assertEquals(UserProfile::DEFAULT_IMAGE, $user->profile->avatarUrl);
    }

    /** @test */
    public function getCompletedBadges_returns_a_collection()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->getCompletedBadges());
    }

    /** @test */
    public function getCompletedBadges_returns_empty_collection_when_no_badges()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->assertCount(0, $user->getCompletedBadges());
    }

    /** @test */
    public function hasBadgeCompleted_returns_false_when_badge_is_not_completed()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create();

        $this->assertFalse($user->hasBadgeCompleted($badge));
    }

    /** @test */
    public function hasBadgeCompleted_returns_false_when_badge_is_completed()
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Badge $badge */
        $badge = Badge::factory()->create([
            'required_repetitions' => 1,
        ]);

        // Complete the badge
        $user->badges()->attach($badge->id, ['repetitions' => '1', 'completed' => true]);

        $this->assertTrue($user->hasBadgeCompleted($badge));
    }
}
