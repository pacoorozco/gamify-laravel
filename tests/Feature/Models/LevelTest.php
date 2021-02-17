<?php

namespace Tests\Feature\Models;

use Gamify\Models\Level;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LevelTest extends TestCase
{
    use RefreshDatabase;

    private function createLevels(int $number, int $distance = 10): void
    {
        for ($i = 1; $i <= $number; $i++) {
            Level::factory()->create([
                'name' => 'Level ' . $i,
                'required_points' => $i * $distance,
                'active' => true,
            ]);
        }
    }

    public function test_findByExperience_method_returns_a_level()
    {
        // create some levels (max: 50 points)
        $this->createLevels(5, 10);

        $test_data = [
            0 => 'Level 0',
            1 => 'Level 0',
            10 => 'Level 1',
            11 => 'Level 1',
            49 => 'Level 4',
            50 => 'Level 5',
            60 => 'Level 5',
        ];

        foreach ($test_data as $input => $want) {
            $this->assertEquals(
                $want, Level::findByExperience($input)->name,
                sprintf("Test case: experience='%d', want='%s'", $input, $want)
            );
        }
    }

    public function test_findNextByExperience_method_returns_a_level()
    {
        // create some levels (max: 50 points)
        $this->createLevels(5, 10);

        $test_data = [
            0 => 'Level 1',
            1 => 'Level 1',
            10 => 'Level 2',
            11 => 'Level 2',
            49 => 'Level 5',
            50 => 'Exception',
            60 => 'Exception',
        ];

        foreach ($test_data as $input => $want) {
            if ($want === 'Exception') {
                $this->expectException(ModelNotFoundException::class);
            }

            $got = Level::findNextByExperience($input)->name;

            $this->assertEquals(
                $want, $got,
                sprintf("Test case: experience='%d', want='%s'", $input, $want)
            );
        }
    }

    public function test_returns_default_image_when_field_is_empty()
    {
        $level = Level::factory()->create();

        $this->assertNull($level->getOriginal('image_url'));
        $this->assertEquals(Level::DEFAULT_IMAGE, $level->image);
    }
}
