<?php

namespace Gamify\Presenters;

use Gamify\Models\Question;
use Illuminate\Support\HtmlString;
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

    /**
     * Returns the question status as a badge.
     * Note: It returns an HtmlString to be able to use `{{ }}` on blade.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function statusBadge(): HtmlString
    {
        return new HtmlString(sprintf(
            '<span class="label %s">%s</span>',
            $this->mapStatusToLabel($this->model->status),
            (string) __('admin/question/model.status_list.' . $this->model->status)
        ));
    }

    /**
     * Returns the question visibility as a badge.
     * Note: It returns an HtmlString to be able to use `{{ }}` on blade.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function visibilityBadge(): HtmlString
    {
        if ($this->model->hidden == true) {
            return new HtmlString(sprintf(
                '<span class="label label-default">%s</span>',
                (string) __('admin/question/model.hidden_yes')
            ));
        }

        return new HtmlString(sprintf(
            '<span class="label label-default hidden">%s</span>',
            (string) __('admin/question/model.hidden_no')
        ));
    }

    /**
     * Returns the statement of the question.
     * Note: It returns an HtmlString to be able to use `{{ }}` on blade.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function statement(): HtmlString
    {
        return new HtmlString((string) $this->model->question);
    }

    /**
     * Returns the explanation of the question.
     * Note: It returns an HtmlString to be able to use `{{ }}` on blade.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function explanation(): HtmlString
    {
        return new HtmlString((string) $this->model->solution);
    }

    /**
     * Returns the public link to the question.
     * Note: It returns an HtmlString to be able to use `{{ }}` on blade.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function publicUrlLink(): HtmlString
    {
        return new HtmlString(sprintf(
            '<a href="%s" target="_blank" class="text-muted"><i class="fa fa-link"></i></a>',
            route('questions.show', ['questionname' => $this->model->short_name]),
        ));
    }

    /**
     * Returns an icon depending question type.
     * Note: It returns an HtmlString to be able to use `{{ }}` on blade.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function typeIcon(): HtmlString
    {
        return new HtmlString(sprintf(
            '<i class="fa fa-tags" data-toggle="tooltip" title="%s"></i><span class="hidden">%s</span>',
            (string) __('admin/question/model.type_list.' . $this->model->type),
            (string) $this->model->type,
        ));
    }

    /**
     * Map a Question status to a color label.
     *
     * @param string $status
     * @param string $default
     *
     * @return string
     */
    protected function mapStatusToLabel(string $status, string $default = 'label-default')
    {
        $LabelToColorDict = [
            Question::DRAFT_STATUS => 'label-default',
            Question::PUBLISH_STATUS => 'label-success',
            Question::FUTURE_STATUS => 'label-info',
            Question::PENDING_STATUS => 'label-warning',
        ];

        return (string) $LabelToColorDict[$status] ?? $default;
    }
}
