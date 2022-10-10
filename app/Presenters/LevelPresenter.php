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

use Gamify\Models\Level;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Laracodes\Presenter\Presenter;

class LevelPresenter extends Presenter
{
    /** @var Level */
    protected $model;

    public function imageThumbnail(): HtmlString
    {
        $imageTag = sprintf('<img class="img-thumbnail" src="%s" alt="%s" title="%s">',
            $this->model->imageUrl('image_url'),
            $this->model->name,
            $this->model->name);

        return Str::of($imageTag)
            ->toHtmlString();
    }

    public function imageTag(): HtmlString
    {
        return Str::of($this->model->imageTag('image_url'))
            ->toHtmlString();
    }

    public function status(): string
    {
        return ($this->model->active)
            ? trans('general.yes')
            : trans('general.no');
    }

    public function nameWithStatusBadge(): HtmlString
    {
        $badge = $this->model->active
            ? $this->name()
            : $this->name().' '.$this->statusBadge();

        return Str::of($badge)
            ->toHtmlString();
    }

    public function name(): string
    {
        return $this->model->name;
    }

    public function statusBadge(): HtmlString
    {
        $badge = $this->model->active
            ? ''
            : '<span class="label label-default">'.trans('general.disabled').'</span>';

        return Str::of($badge)
            ->toHtmlString();
    }
}
