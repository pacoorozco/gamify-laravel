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

use Gamify\Models\User;
use Illuminate\Support\HtmlString;
use Laracodes\Presenter\Presenter;

class UserPresenter extends Presenter
{
    /** @var User */
    protected $model;

    public function role(): string
    {
        return $this->model->role->description
            ?? '';
    }

    public function createdAt(): string
    {
        return $this->model->created_at?->toFormattedDateString()
            ?? '';
    }

    public function birthdate(): string
    {
        return $this->model->profile->date_of_birth?->toFormattedDateString()
            ?? '';
    }

    public function bio(): string
    {
        return $this->model->profile->bio
            ?? '';
    }

    public function adminLabel(): HtmlString
    {
        return new HtmlString($this->model->isAdmin()
            ? '<span class="label label-warning">'.$this->role().'</span>'
            : ''
        );
    }
}
