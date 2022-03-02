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
 * @property string $url Homepage.
 * @property string $avatarUrl URL of the avatar.
 * @property string $phone Phone number.
 * @property Carbon $date_of_birth Date of Birth.
 * @property string $gender Gender, could be 'male', 'female' or 'unspecified'.
 * @property string $twitter Twitter username
 * @property string $facebook Facebook username
 * @property string $linkedin LinkedIn username
 * @property string $github GitHub username
 * @property User $user User wo belongs to.
 * @property string $imagesUploadDisk
 * @property string $imagesUploadPath
 * @property string $autoUploadImages
 */
class UserProfile extends Model
{
    use HasImageUploads;
    use HasFactory;

    /**
     * Default badge image to be used in case no one is supplied.
     */
    const DEFAULT_IMAGE = '/images/missing_profile.png';

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
    ];

    /**
     * Path in disk to use for upload, can be override by field options.
     *
     * @var string
     */
    protected string $imagesUploadPath = 'avatars';

    /**
     * Auto upload allowed.
     *
     * @var bool
     */
    protected bool $autoUploadImages = true;

    /**
     * Fields that are managed by the HasImageUploads trait.
     *
     * @var array
     */
    protected static $imageFields = [
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

    /**
     * UserProfile are attached to every User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get image attribute or default image.
     *
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        try {
            return $this->imageUrl('avatar');
        } catch (\Throwable $exception) {
            return asset(self::DEFAULT_IMAGE);
        }
    }
}
