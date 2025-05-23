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
use Gamify\Models\Question;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class QuestionPresenter extends Presenter
{
    /** @var Question */
    protected $model;

    /**
     * Returns the question status as a badge.
     * Note: It returns an HtmlString to be able to use `{{ }}` on blade.
     */
    public function statusBadge(): HtmlString
    {
        $badge = sprintf('<span class="badge %s">%s</span>',
            $this->mapStatusToLabel($this->model->status),
            trans('admin/question/model.status_list.'.$this->model->status)
        );

        return Str::of($badge)
            ->toHtmlString();
    }

    /**
     * Map a Question status to a color label.
     *
     * @param string $status
     * @param string $default
     * @return string
     */
    protected function mapStatusToLabel(string $status, string $default = 'badge-secondary'): string
    {
        $LabelToColorDict = [
            Question::DRAFT_STATUS => 'badge badge-secondary',
            Question::PUBLISH_STATUS => 'badge badge-success',
            Question::FUTURE_STATUS => 'badge badge-info',
            Question::PENDING_STATUS => 'badge badge-warning',
        ];

        return $LabelToColorDict[$status] ?? $default;
    }

    /**
     * Returns the question visibility as a badge.
     * Note: It returns an HtmlString to be able to use `{{ }}` on blade.
     */
    public function visibilityBadge(): HtmlString
    {
        $badge = $this->model->hidden
            ? '<span class="badge badge-secondary">' . trans('admin/question/model.hidden_yes') . '</span>'
            : '';

        return Str::of($badge)
            ->toHtmlString();
    }

    public function visibility(): string
    {
        return $this->model->hidden
            ? trans('admin/question/model.hidden_yes')
            : trans('admin/question/model.hidden_no');
    }

    /**
     * Returns the statement of the question.
     * Note: It returns an HtmlString to be able to use `{{ }}` on blade.
     */
    public function statement(): HtmlString
    {
        return Str::of($this->model->question)
            ->toHtmlString();
    }

    /**
     * Returns the explanation of the question.
     * Note: It returns an HtmlString to be able to use `{{ }}` on blade.
     */
    public function explanation(): HtmlString
    {
        return Str::of($this->model->solution)
            ->toHtmlString();
    }

    /**
     * Returns the public link to the question.
     * Note: It returns an HtmlString to be able to use `{{ }}` on blade.
     */
    public function publicUrlLink(): HtmlString
    {
        return Str::of(sprintf(
            '<a href="%s" target="_blank" class="text-muted" title="Preview"><i class="bi bi-box-arrow-up-right"></i></a>',
            route('questions.show', [
                'q_hash' => $this->model->hash,
                'slug' => $this->model->slug,
            ]),
        ))
            ->toHtmlString();
    }

    public function publicationDateDescription(): string
    {
        return match ($this->model->status) {
            Question::PUBLISH_STATUS => trans('admin/question/model.published_on',
                ['datetime' => $this->publicationDate()]),
            Question::FUTURE_STATUS => trans('admin/question/model.scheduled_for',
                ['datetime' => $this->publicationDate()]),
            default => trans('admin/question/model.published_not_yet'),
        };
    }

    public function publicationDate(): string
    {
        return empty($this->model->publication_date)
            ? ''
            : $this->model->publication_date->format('Y-m-d H:i');
    }

    public function creator(): string
    {
        return $this->model->creator->username ?? 'N/A';
    }

    public function updater(): string
    {
        return $this->model->updater->username ?? 'N/A';
    }

    public function tags(): HtmlString
    {
        return Str::of(collect($this->model->tagArrayNormalized)
            ->map(fn($value) => '<span class="badge badge-pill badge-primary">' . $value . '</span>')
            ->implode(' '))
            ->toHtmlString();
    }
}
