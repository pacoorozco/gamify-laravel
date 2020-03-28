<?php

namespace Tests\Unit;

use Gamify\UserProfile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\ModelTestCase;

class UserProfileTest extends ModelTestCase
{
    public function test_contains_valid_fillable_properties()
    {
        $m = new UserProfile();
        $this->assertEquals([
            'bio',
            'url',
            'phone',
            'date_of_birth',
            'gender',
            'twitter',
            'facebook',
            'linkedin',
            'github',
            'avatar',
        ], $m->getFillable());
    }

    public function test_contains_valid_casts_properties()
    {
        $m = new UserProfile();
        $this->assertEquals([
            'id' => 'int',
            'bio' => 'string',
            'url' => 'string',
            'phone' => 'string',
            'date_of_birth' => 'string',
            'gender' => 'string',
            'twitter' => 'string',
            'facebook' => 'string',
            'linkedin' => 'string',
            'github' => 'string',
            'avatar' => 'string',
        ], $m->getCasts());
    }

    public function test_user_relation()
    {
        $m = new UserProfile();
        $r = $m->user();
        $this->assertInstanceOf(BelongsTo::class, $r);
    }
}
