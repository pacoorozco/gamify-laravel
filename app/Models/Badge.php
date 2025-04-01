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

use Coderflex\LaravelPresenter\Concerns\CanPresent;
use Coderflex\LaravelPresenter\Concerns\UsesPresenters;
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
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
class Badge extends Model implements HasMedia, CanPresent
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;
    use Taggable;
    use UsesPresenters;

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile()
            ->useFallbackUrl('/images/missing_badge.png')
            ->useFallbackPath(public_path('/images/missing_badge.png'))
            ->registerMediaConversions(function (): void {
                $this
                    ->addMediaConversion('thumb')
                    ->width(150)
                    ->height(150);

                $this
                    ->addMediaConversion('detail')
                    ->width(300)
                    ->height(300);
            });
    }

    protected array $presenters = [
        'default' => BadgePresenter::class,
    ];

    protected $fillable = [
        'name',
        'description',
        'required_repetitions',
        'active',
        'actuators',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'actuators' => BadgeActuators::class,
        ];
    }

    public static function triggeredByQuestionsWithTagsIn(array $tags): Collection
    {
        return self::query()
            ->active()
            ->whereIn('actuators', BadgeActuators::triggeredByQuestions())
            ->when($tags, function ($query) use ($tags): void {
                $query->withAnyTags($tags);
            }, function ($query): void {
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
            ->whereIn('actuators', $actuators);
    }

    public function slug(): string
    {
        return Str::slug($this->name);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->getFirstMediaUrl('image', 'detail')
        );
    }
}
