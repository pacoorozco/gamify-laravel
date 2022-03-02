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

use Gamify\Enums\BadgeActuators;
use Gamify\Presenters\BadgePresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracodes\Presenter\Traits\Presentable;
use QCod\ImageUp\HasImageUploads;

/**
 * Model that represents a badge.
 *
 * @property int $id Object unique id.
 * @property string $name Name of this badge.
 * @property string $description Description of the badge.
 * @property int $required_repetitions How many times you need to request the badge to achieve it.
 * @property string $image URL of the badge's image
 * @property bool $active Is this badge enabled?
 * @property BadgeActuators $actuators Events that triggers this badge completion.
 * @property string $imagesUploadDisk
 * @property string $imagesUploadPath
 * @property string $autoUploadImages
 */
class Badge extends Model
{
    use SoftDeletes;
    use HasImageUploads;
    use Presentable;
    use HasFactory;

    /**
     * Default badge image to be used in case no one is supplied.
     */
    const DEFAULT_IMAGE = '/images/missing_badge.png';

    /**
     * Model presenter.
     *
     * @var string
     */
    protected string $presenter = BadgePresenter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'required_repetitions',
        'active',
        'actuators',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'description' => 'string',
        'required_repetitions' => 'int',
        'active' => 'boolean',
        'actuators' => BadgeActuators::class,
    ];

    /**
     * Path in disk to use for upload, can be override by field options.
     *
     * @var string
     */
    protected string $imagesUploadPath = 'badges';

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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Returns a collection of active Badges.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to only include badges with the given actuators.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Gamify\Enums\QuestionActuators[]  $actuators
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithActuatorsIn(Builder $query, array $actuators): Builder
    {
        return $query->whereIn('actuators', $actuators);
    }
}
