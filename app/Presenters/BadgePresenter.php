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

use Gamify\Enums\BadgeActuators;
use Gamify\Models\Badge;
use Illuminate\Support\HtmlString;
use Laracodes\Presenter\Presenter;

class BadgePresenter extends Presenter
{
    /** @var \Gamify\Models\Badge */
    protected $model;

    /**
     * Returns an array of values to be used on <select>. It's filtering some actuators and adding <optgroups> to group
     * them.
     *
     * @return array
     */
    public static function actuatorsSelect(): array
    {
        return [
            BadgeActuators::None()->value => BadgeActuators::None()->description,
            trans('admin/badge/model.actuators_related_with_question_events') => [
                BadgeActuators::OnQuestionAnswered()->value => BadgeActuators::OnQuestionAnswered()->description,
                BadgeActuators::OnQuestionCorrectlyAnswered()->value => BadgeActuators::OnQuestionCorrectlyAnswered()->description,
                BadgeActuators::OnQuestionIncorrectlyAnswered()->value => BadgeActuators::OnQuestionIncorrectlyAnswered()->description,
            ],
            trans('admin/badge/model.actuators_related_with_user_events') => [
                BadgeActuators::OnUserLogin()->value => BadgeActuators::OnUserLogin()->description,
            ],
        ];
    }

    public function status(): string
    {
        return ($this->model->active)
            ? trans('general.yes')
            : trans('general.no');
    }

    public function imageThumbnail(): HtmlString
    {
        return new HtmlString((string) $this->model->imageTag('image_url', 'class="img-thumbnail"'));
    }

    public function imageTableThumbnail(): HtmlString
    {
        return new HtmlString((string) $this->model->imageTag('image_url',
            'class="img-thumbnail center-block" width="96"'));
    }

    public function imageTag(): HtmlString
    {
        return new HtmlString((string) $this->model->imageTag('image_url'));
    }

    public function actuators(): array
    {
        return $this->model->actuators->getFlags();
    }
}
