<?php

namespace Tests\Unit;

use Gamify\Point;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\ModelTestCase;

class PointTest extends ModelTestCase
{
    public function test_contains_valid_fillable_properties()
    {
        $m = new Point();
        $this->assertEquals([
            'points',
            'description',
        ], $m->getFillable());
    }

    public function test_contains_valid_casts_properties()
    {
        $m = new Point();
        $this->assertEquals([
            'id' => 'int',
            'points' => 'int',
            'description' => 'string',
        ], $m->getCasts());
    }

    public function test_user_relation()
    {
        $m = new Point();
        $r = $m->user();
        $this->assertInstanceOf(BelongsTo::class, $r);
    }
}
