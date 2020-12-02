<?php

namespace Tests\Feature\Models;

use Gamify\Badge;
use Gamify\Question;
use Gamify\User;
use Gamify\UserProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function pendingQuestions_returns_a_collection()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->pendingQuestions());
    }

    /** @test */
    public function pendingQuestions_returns_specified_number_of_questions()
    {
        // Creates 5 published questions.
        $this->actingAsAdmin();
        factory(Question::class, 5)
            ->states('with_choices')
            ->create([
                'status' => Question::PUBLISH_STATUS,
                'publication_date' => now(),
            ]);
        $user = factory(User::class)->create();

        // We only want 3 of the 5 created questions.
        $this->assertCount(3, $user->pendingQuestions(3));
    }

    /** @test */
    public function pendingQuestions_returns_zero_when_no_questions()
    {
        $user = factory(User::class)->create();

        $this->assertCount(0, $user->pendingQuestions());
    }

    /** @test */
    public function addExperience_method()
    {
        $user = factory(User::class)->create();

        $want = 15;
        $user->addExperience($want);

        $this->assertEquals($want, $user->experience);
    }

    /** @test */
    public function returns_default_image_when_avatar_is_empty()
    {
        $user = factory(User::class)->state('with_profile')->create();

        $this->assertNull($user->profile->getOriginal('avatar'));
        $this->assertEquals(UserProfile::DEFAULT_IMAGE, $user->profile->avatar);
    }

    /** @test */
    public function getCompletedBadges_returns_a_collection()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->getCompletedBadges());
    }

    /** @test */
    public function getCompletedBadges_returns_empty_collection_when_no_badges()
    {
        $user = factory(User::class)->create();

        $this->assertCount(0, $user->getCompletedBadges());
    }

    /** @test */
    public function hasBadgeCompleted_returns_false_when_badge_is_not_completed()
    {
        $user = factory(User::class)->create();
        $badge = factory(Badge::class)->create();

        $this->assertFalse($user->hasBadgeCompleted($badge));
    }

    /** @test */
    public function hasBadgeCompleted_returns_false_when_badge_is_completed()
    {
        $user = factory(User::class)->create();
        $badge = factory(Badge::class)->create([
            'required_repetitions' => 1,
        ]);

        // Complete the badge
        $user->badges()->attach($badge->id, ['repetitions' => '1', 'completed' => true]);

        $this->assertTrue($user->hasBadgeCompleted($badge));
    }
}
