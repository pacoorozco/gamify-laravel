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
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Gamify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Role model, represents a role.
 *
 * @property int    $id                   The object unique id.
 * @property string $bio                  Short bio information.
 * @property string $url                  Homepage.
 * @property string $avatar               URL of the avatar.
 * @property string $phone                Phone number.
 * @property Carbon $date_of_birth        Date of Birth.
 * @property string $gender               Gender, could be 'male', 'female' or 'unspecified'.
 * @property string $twitter              Twitter username
 * @property string $facebook             Facebook username
 * @property string $linkedin             LinkedIn username
 * @property string $github               GitHub username
 * @property User   $user                 User wo belongs to.
 */
class UserProfile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        'avatar',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'bio' => 'string',
        'url' => 'string',
        'phone' => 'string',
        'date_of_birth' => 'string',
        'gender' => 'string',
        'twitter' => 'string',
        'facebook' => 'string',
        'linkedin' => 'string',
        'github' => 'string',
        'avatar' => 'string',
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

    /**
     * Returns avatar URL.
     *
     * @return string
     */
    public function getAvatarURL(): string
    {
        return asset('images/missing_profile.png');
    }
}
