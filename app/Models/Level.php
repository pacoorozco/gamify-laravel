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
use Gamify\Presenters\LevelPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Model that represents a level.
 *
 * @property int $id Object unique id.
 * @property string $name Name of the level..
 * @property int $required_points How many points do you need to achieve it.
 * @property string $image URL of the level's image
 * @property bool $active Is this level enabled?
 */
class Level extends Model implements HasMedia, CanPresent
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;
    use UsesPresenters;

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->singleFile()
            ->useFallbackUrl('/images/missing_level.png')
            ->useFallbackPath(public_path('/images/missing_level.png'))
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
        'default' => LevelPresenter::class,
    ];

    protected $fillable = [
        'name',
        'required_points',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public static function findNextByExperience(int $experience): Level
    {
        return Cache::rememberForever('levels', function () {
            return self::query()
                ->active()
                ->orderBy('required_points', 'ASC')
                ->get();
        })
            ->where('required_points', '>', $experience)
            ->first()
            ?? self::findByExperience($experience);
    }

    public static function findByExperience(int $experience): Level
    {
        return Cache::rememberForever('levels', function () {
            return self::query()
                ->active()
                ->orderBy('required_points', 'ASC')
                ->get();
        })
            ->where('required_points', '<=', $experience)
            ->last()
            ?? self::defaultLevel();
    }

    /**
     * The default level could be overridden by creating another Level with
     * required_points = 0.
     *
     * @return \Gamify\Models\Level
     */
    public static function defaultLevel(): Level
    {
        return new Level([
            'name' => 'Default',
            'required_points' => 0,
            'active' => true,
        ]);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getFirstMediaUrl('image', 'detail')
        );
    }
}
