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

namespace Gamify\Presenters;

use Coderflex\LaravelPresenter\Presenter;
use Gamify\Models\Badge;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class BadgePresenter extends Presenter
{
    /** @var Badge */
    protected $model;

    public function status(): string
    {
        return ($this->model->active)
            ? trans('general.yes')
            : trans('general.no');
    }

    public function nameWithStatusBadge(): HtmlString
    {
        $badge = $this->model->active
            ? $this->model->name
            : $this->model->name.' '.$this->statusBadge();

        return Str::of($badge)
            ->toHtmlString();
    }

    public function statusBadge(): HtmlString
    {
        $badge = $this->model->active
            ? ''
            : '<span class="label label-default">'.trans('general.disabled').'</span>';

        return Str::of($badge)
            ->toHtmlString();
    }

    public function imageThumbnail(): HtmlString
    {
        $imageTag = sprintf('<img class="img-thumbnail" src="%s" alt="%s" title="%s">',
            $this->model->getFirstMediaUrl('image', 'thumb'),
            $this->model->description,
            $this->model->name);

        return Str::of($imageTag)
            ->toHtmlString();
    }

    public function imageTag(): HtmlString
    {
        $imageTag = sprintf('<imgsrc="%s" alt="%s" title="%s">',
            $this->model->getFirstMediaUrl('image', 'detail'),
            $this->model->description,
            $this->model->name);

        return Str::of($imageTag)
            ->toHtmlString();
    }

    public function unlockedAt(): string
    {
        /** @phpstan-ignore-next-line */
        return $this->model->progress->completed_at?->toFormattedDateString()
            ?? '';
    }

    public function tags(): HtmlString
    {
        return Str::of(collect($this->model->tagArrayNormalized)
            ->map(fn ($value) => '<span class="label label-primary">'.$value.'</span>')
            ->implode(' '))
            ->toHtmlString();
    }

    public function tagsIn(array $tags): HtmlString
    {
        return Str::of(collect($this->model->tagArrayNormalized)->intersect($tags)
            ->map(fn ($value) => '<span class="label label-default">'.$value.'</span>')
            ->implode(' '))
            ->toHtmlString();
    }
}
