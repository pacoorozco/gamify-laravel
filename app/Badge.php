<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE, AUTHORS.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-l5
 */

namespace Gamify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model that represents a badge.
 *
 * @property int    $id                    Object unique id.
 * @property string $name                  Name of this badge.
 * @property string $description           Description of the badge.
 * @property int    $required_repetitions  How many times you need to request the badge to achieve it.
 * @property string image_url              URL of the badge's image
 * @property bool   active                 Is this badge enabled?
 */
class Badge extends Model
{
    use SoftDeletes;

    protected $table = 'badges';
    protected $fillable = [
        'name',
        'description',
        'required_repetitions',
        'image_url',
        'active',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Returns Image URL.
     *
     * @return string
     */
    public function getImageURL(): string
    {
        return asset('images/missing_badge.png');
    }
}
