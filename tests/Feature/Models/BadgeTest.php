<?php

namespace Tests\Feature\Models;

use Gamify\Badge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BadgeTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_uploaded_image()
    {
        $badge = factory(Badge::class)->create();
        Storage::fake('public');

        $image = UploadedFile::fake()->image('badge.jpg');
        $this->assertNull($badge->getOriginal('image_url'));
        $badge->uploadImage($image);

        $this->assertEquals('badges/'.$image->hashName(), $badge->fresh()->getOriginal('image_url'));
        $this->assertEquals('/storage/badges/'.$image->hashName(), $badge->image);
    }

    public function test_returns_default_image_when_field_is_empty()
    {
        $badge = factory(Badge::class)->create();

        $this->assertNull($badge->getOriginal('image_url'));
        $this->assertEquals(Badge::DEFAULT_IMAGE, $badge->image);
    }
}
