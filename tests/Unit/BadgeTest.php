<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 - 2020 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 - 2020 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Tests\Unit;

use Gamify\Badge;
use Tests\ModelTestCase;

class BadgeTest extends ModelTestCase
{
    public function test_contains_valid_fillable_properties()
    {
        $m = new Badge();
        $this->assertEquals([
            'name',
            'description',
            'required_repetitions',
            'image_url',
            'active',
        ], $m->getFillable());
    }

    public function test_contains_valid_casts_properties()
    {
        $m = new Badge();
        $this->assertEquals([
            'id' => 'int',
            'name' => 'string',
            'description' => 'string',
            'required_repetitions' => 'int',
            'image_url' => 'string',
            'active' => 'boolean',
        ], $m->getCasts());
    }
}
