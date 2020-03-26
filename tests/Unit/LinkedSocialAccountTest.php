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

use Gamify\LinkedSocialAccount;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\ModelTestCase;

class LinkedSocialAccountTest extends ModelTestCase
{
    public function test_contains_valid_fillable_properties()
    {
        $m = new LinkedSocialAccount();
        $this->assertEquals([
            'provider_name',
            'provider_id',
        ], $m->getFillable());
    }

    public function test_contains_valid_casts_properties()
    {
        $m = new LinkedSocialAccount();
        $this->assertEquals([
            'id' => 'int',
            'provider_name' => 'string',
            'provider_id' => 'int',
        ], $m->getCasts());
    }

    public function test_user_relation()
    {
        $m = new LinkedSocialAccount();
        $r = $m->user();
        $this->assertInstanceOf(BelongsTo::class, $r);
    }
}
