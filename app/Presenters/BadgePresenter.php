<?php

namespace Gamify\Presenters;

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
        return ($this->model->active) ? (string) __('general.yes') : (string) __('general.no');
    }

    /**
     * Returns the image HTML tag for a thumbnail.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function imageThumbnail(): HtmlString
    {
        return new HtmlString($this->model->imageTag('image_url', 'class="img-thumbnail"'));
    }

    /**
     * Returns the image HTML tag for a column table.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function imageTableThumbnail(): HtmlString
    {
        return new HtmlString($this->model->imageTag('image_url', 'class="img-thumbnail center-block" width="96"'));
    }

    /**
     * Returns the image HTML tag.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function imageTag(): HtmlString
    {
        return new HtmlString($this->model->imageTag('image_url'));
    }
}
