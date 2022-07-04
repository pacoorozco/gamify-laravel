<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Gamify\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use QCod\ImageUp\HasImageUploads;

/**
 * Role model, represents a role.
 *
 * @property int $id The object unique id.
 * @property string $bio Short bio information.
 * @property string $avatarUrl URL of the avatar.
 * @property ?Carbon $date_of_birth Date of Birth.
 * @property string $twitter Twitter username
 * @property string $facebook Facebook username
 * @property string $linkedin LinkedIn username
 * @property string $github GitHub username
 * @property User $user User wo belongs to.
 */
class UserProfile extends Model
{
    use HasImageUploads;
    use HasFactory;

    const DEFAULT_IMAGE = '/images/missing_profile.png';

    protected $fillable = [
        'bio',
        'date_of_birth',
        'twitter',
        'facebook',
        'linkedin',
        'github',
    ];

    protected $casts = [
        'date_of_birth' => 'datetime',
    ];

    protected string $imagesUploadPath = 'avatars';

    protected bool $autoUploadImages = true;

    protected static array $imageFields = [
        'avatar' => [
            // width to resize image after upload
            'width' => 150,

            // height to resize image after upload
            'height' => 150,

            // set true to crop image with the given width/height and you can also pass arr [x,y] coordinate for crop.
            'crop' => true,

            // placeholder image if image field is empty
            'placeholder' => self::DEFAULT_IMAGE,

            // validation rules when uploading image
            'rules' => 'image|max:2000',

            // if request file is don't have same name, default will be the field name
            'file_input' => 'image',
        ],
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->imageUrl()
        );
    }
}
