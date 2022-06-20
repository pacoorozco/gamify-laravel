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
use Laracodes\Presenter\Presenter;

class LevelPresenter extends Presenter
{
    /** @var Level */
    protected $model;

    public function image(): string
    {
        return sprintf('<img src="%s" width="96" class="img-thumbnail" alt="%s">',
            $this->model->imageUrl(),
            $this->model->name);
    }

    public function active(): string
    {
        return $this->model->active
            ? trans('general.yes')
            : trans('general.no');
    }
}
