<?php

namespace Tests\Unit;

use Gamify\Level;
use Tests\ModelTestCase;

class LevelTest extends ModelTestCase
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
