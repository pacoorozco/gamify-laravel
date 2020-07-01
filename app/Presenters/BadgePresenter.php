<?php

namespace Gamify\Presenters;

use Gamify\Enums\BadgeActuators;
use Illuminate\Support\HtmlString;
use Laracodes\Presenter\Presenter;

class BadgePresenter extends Presenter
{
    /**
     * Returns the badge status in the local language.
     *
     * @return string
     */
    public function status(): string
    {
        return ($this->model->active) ? (string)__('general.yes') : (string)__('general.no');
    }

    /**
     * Returns the image HTML tag for a thumbnail.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function imageThumbnail(): HtmlString
    {
        return new HtmlString((string)$this->model->imageTag('image_url', 'class="img-thumbnail"'));
    }

    /**
     * Returns the image HTML tag for a column table.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function imageTableThumbnail(): HtmlString
    {
        return new HtmlString((string)$this->model->imageTag('image_url', 'class="img-thumbnail center-block" width="96"'));
    }

    /**
     * Returns the image HTML tag.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function imageTag(): HtmlString
    {
        return new HtmlString((string)$this->model->imageTag('image_url'));
    }

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
            __('admin/badge/model.actuators_related_with_question_events') => [
                BadgeActuators::OnQuestionAnswered()->value => BadgeActuators::OnQuestionAnswered()->description,
                BadgeActuators::OnQuestionCorrectlyAnswered()->value => BadgeActuators::OnQuestionCorrectlyAnswered()->description,
                BadgeActuators::OnQuestionIncorrectlyAnswered()->value => BadgeActuators::OnQuestionIncorrectlyAnswered()->description,
            ],
            __('admin/badge/model.actuators_related_with_user_events') => [
                BadgeActuators::OnUserLogin()->value => BadgeActuators::OnUserLogin()->description,
            ],
        ];
    }

    /**
     * Returns an array of actuators.
     *
     * @return array
     */
    public function actuators(): array
    {
        return optional($this->model->actuators)->getFlags() ?? [];
    }
}
