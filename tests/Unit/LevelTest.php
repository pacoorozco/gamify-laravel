<?php

namespace Tests\Unit;

use Gamify\Level;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LevelTest extends TestCase
{
    public function test_contains_valid_fillable_properties()
    {
        $m = new Level();
        $this->assertEquals([
            'name',
            'required_points',
            'image_url',
            'active',
        ], $m->getFillable());
    }

    public function test_contains_valid_casts_properties()
    {
        $m = new Level();
        $this->assertEquals([
            'id' => 'int',
            'name' => 'string',
            'required_points' => 'int',
            'image_url' => 'string',
            'active' => 'boolean',
        ], $m->getCasts());
    }
}
