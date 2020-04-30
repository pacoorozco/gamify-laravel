<?php

namespace Tests\Feature\Models;

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
        $u = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $u->pendingQuestions());
    }

    /** @test */
    public function pendingQuestions_returns_specified_number_of_questions()
    {
        $u = factory(User::class)->create();
        // Creates 5 published questions.
        $this->createQuestionAsAdmin(5)->each(function (Question $q) {
              $q->publish();
        });

        // We only want 3 of the 5 created questions.
        $this->assertCount(3, $u->pendingQuestions(3));
    }

    /** @test */
    public function pendingQuestions_returns_zero_when_no_questions()
    {
        $u = factory(User::class)->create();

        $this->assertCount(0, $u->pendingQuestions());
    }

    /** @test */
    public function addExperience_method()
    {
        $u = factory(User::class)->create();

        $want = 15;
        $u->addExperience($want);

        $this->assertEquals($want, $u->experience);
    }

    /** @test  */
    public function returns_image_when_uploaded_avatar()
    {
        $user = factory(User::class)->state('with_profile')->create();
        Storage::fake('public');

        $image = UploadedFile::fake()->image('avatar.jpg');
        $this->assertNull($user->getOriginal('avatar'));
        $user->profile->uploadImage($image);

        $this->assertEquals('avatars/' . $image->hashName(), $user->profile->fresh()->getOriginal('avatar'));
        $this->assertEquals('/storage/avatars/' . $image->hashName(), $user->profile->avatar);
    }

    /** @test */
    public function returns_default_image_when_avatar_is_empty()
    {
        $user = factory(User::class)->state('with_profile')->create();

        $this->assertNull($user->profile->getOriginal('avatar'));
        $this->assertEquals(UserProfile::DEFAULT_IMAGE, $user->profile->avatar);
    }
}
