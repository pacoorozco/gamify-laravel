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

    public function test_pendingQuestions_returns_collection()
    {
        $u = factory(User::class)->create();

        factory(Question::class, 5)->create([
            'status' => Question::PUBLISH_STATUS,
        ]);

        $got = $u->pendingQuestions();

        $this->assertInstanceOf(Collection::class, $got);
    }

    public function test_pendingQuestions_with_limit()
    {
        $u = factory(User::class)->create();

        $limit = 2;
        factory(Question::class, $limit + 3)->create([
            'status' => Question::PUBLISH_STATUS,
        ]);

        $this->assertCount($limit, $u->pendingQuestions($limit));
    }

    public function test_addExperience_method()
    {
        $u = factory(User::class)->create();

        $want = 15;
        $u->addExperience($want);

        $this->assertEquals($want, $u->experience);
    }

    public function test_returns_uploaded_image()
    {
        $user = factory(User::class)->create();
        $user->profile()->create();
        Storage::fake('public');

        $image = UploadedFile::fake()->image('avatar.jpg');
        $this->assertNull($user->getOriginal('avatar'));
        $user->profile->uploadImage($image);

        $this->assertEquals('avatars/'.$image->hashName(), $user->profile->fresh()->getOriginal('avatar'));
        $this->assertEquals('/storage/avatars/'.$image->hashName(), $user->profile->avatar);
    }

    public function test_returns_default_image_when_field_is_empty()
    {
        $user = factory(User::class)->create();
        $user->profile()->create();

        $this->assertNull($user->profile->getOriginal('avatar'));
        $this->assertEquals(UserProfile::DEFAULT_IMAGE, $user->profile->avatar);
    }
}
