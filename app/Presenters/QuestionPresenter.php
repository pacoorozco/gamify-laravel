<?php

namespace Gamify\Presenters;

use Laracodes\Presenter\Presenter;

class QuestionPresenter extends Presenter
{
    /**
     * Returns publication_date with predefined format.
     *
     * @return string
     */
    public function publicationDate(): string
    {
        return empty($this->model->publication_date)
            ? ''
            : $this->model->publication_date->format('Y-m-d H:i');
    }

    /**
     * Returns the public URL of a question.
     *
     * @return string
     */
    public function publicUrl(): string
    {
        return route('questions.show', ['questionname' => $this->model->short_name]);
    }
}
