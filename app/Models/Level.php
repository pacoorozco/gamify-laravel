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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use QCod\ImageUp\HasImageUploads;

/**
 * Model that represents a level.
 *
 * @property int $id Object unique id.
 * @property string $name Name of the level..
 * @property int $required_points How many points do you need to achieve it.
 * @property string $image URL of the level's image
 * @property bool $active Is this level enabled?
 * @property string $imagesUploadDisk
 * @property string $imagesUploadPath
 * @property string $autoUploadImages
 */
class Level extends Model
{
    use SoftDeletes;
    use HasImageUploads;
    use HasFactory;

    const DEFAULT_IMAGE = '/images/missing_level.png';
    protected static array $imageFields = [
        'image_url' => [
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
    protected $fillable = [
        'name',
        'required_points',
        'active',
    ];
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $dates = ['deleted_at'];
    protected string $imagesUploadPath = 'levels';
    protected bool $autoUploadImages = true;

    public static function findByExperience(int $experience): ?Level
    {
        return self::query()
            ->active()
            ->where('required_points', '<=', $experience)
            ->orderBy('required_points', 'desc')
            ->first();
    }

    public static function findNextByExperience(int $experience): Level
    {
        return self::query()
            ->active()
            ->where('required_points', '>', $experience)
            ->orderBy('required_points', 'asc')
            ->firstOrFail();
    }

    public function getImageAttribute(): string
    {
        try {
            return $this->imageUrl();
        } catch (\Throwable $exception) {
            return asset(self::DEFAULT_IMAGE);
        }
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function isDefault(): bool
    {
        return $this->required_points === 0;
    }
}
