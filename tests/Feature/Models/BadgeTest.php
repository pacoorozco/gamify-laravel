<?php

namespace Tests\Feature\Models;

use Gamify\Enums\BadgeActuators;
use Gamify\Models\Badge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BadgeTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_default_image_when_field_is_empty()
    {
        $badge = Badge::factory()->create();

        $this->assertNull($badge->getOriginal('image_url'));
    }

    /** @test */
    public function it_returns_actuators_as_enum_when_model_is_read_from_database()
    {
        $want = Badge::factory()->create();
        $want->actuators = BadgeActuators::OnUserLogin();
        $want->saveOrFail();

        $got = Badge::find($want)->first();

        $this->assertEquals(BadgeActuators::OnUserLogin(), $got->actuators);
    }
}
