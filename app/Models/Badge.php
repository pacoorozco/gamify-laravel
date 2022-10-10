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

use BenSampo\Enum\Traits\QueriesFlaggedEnums;
use Cviebrock\EloquentTaggable\Taggable;
use Gamify\Enums\BadgeActuators;
use Gamify\Presenters\BadgePresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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
 */
class Badge extends Model
{
    use SoftDeletes;
    use HasImageUploads;
    use HasFactory;
    use Presentable;
    use QueriesFlaggedEnums;
    use Taggable;

    const DEFAULT_IMAGE = '/images/missing_badge.png';

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

    protected string $presenter = BadgePresenter::class;

    protected $fillable = [
        'name',
        'description',
        'required_repetitions',
        'active',
        'actuators',
    ];

    protected $casts = [
        'active' => 'boolean',
        'actuators' => BadgeActuators::class,
    ];

    protected string $imagesUploadPath = 'badges';

    protected bool $autoUploadImages = true;

    public static function triggeredByQuestionsWithTagsIn(array $tags): Collection
    {
        return self::query()
            ->active()
            ->hasAnyFlags('actuators', BadgeActuators::triggeredByQuestions())
            ->when($tags, function ($query) use ($tags) {
                $query->withAnyTags($tags);
            }, function ($query) {
                $query->isNotTagged();
            })
            ->get();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function scopeWithActuatorsIn(Builder $query, array $actuators): Builder
    {
        /** @phpstan-ignore-next-line */
        return $query
            ->active()
            ->hasAnyFlags('actuators', $actuators);
    }

    public function slug(): string
    {
        return Str::slug($this->name);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->imageUrl()
        );
    }
}
