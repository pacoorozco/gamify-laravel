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

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Role model, represents a role.
 *
 * @property int    $id                  The object unique id.
 * @property string $bio                 Short bio information.
 * @property string $url                 Homepage.
 * @property string $avatar              URL of the avatar.
 * @property string $phone               Phone number.
 * @property Carbon $date_of_birth       Date of Birth.
 * @property string $gender              Gender, could be 'male', 'female' or 'unspecified'.
 * @property string $twitter             Twitter username
 * @property string $facebook            Facebook username
 * @property string linkedin             LinkedIn username
 * @property string github               GitHub username
 * @property User   user                 User wo belongs to.
 */
class UserProfile extends Model
{
    protected $table = 'user_profiles';
    protected $fillable = [
        'bio',
        'url',
        'phone',
        'date_of_birth',
        'gender',
        'twitter',
        'facebook',
        'linkedin',
        'github',
    ];

    /**
     * UserProfile are attached to every User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Gamify\User');
    }
}
