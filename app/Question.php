<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE, AUTHORS.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Gamify;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Gamify\Enums\BadgeActuators;
use Gamify\Enums\QuestionActuators;
use Gamify\Events\QuestionPendingReview;
use Gamify\Events\QuestionPublished;
use Gamify\Exceptions\QuestionPublishingException;
use Gamify\Presenters\QuestionPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laracodes\Presenter\Traits\Presentable;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * Class Question.
 *
 *
 * @property  int                        $id               The object unique id.
 * @property  string                     $name             The name of the question.
 * @property  string                     $short_name       The slugged name of the question.
 * @property  string                     $question         The text for the question.
 * @property  string                     $solution         The test for the solution.
 * @property  string                     $type             The question type ['single'. 'multi'].
 * @property  bool                       $hidden           The visibility of the question.
 * @property  string                     $status           The status of the question.
 * @property  string                     $public_url       The public URL of this question.
 * @property  \Gamify\User               $creator          The User who created this question,
 * @property  \Gamify\User               $updater          The last User who updated this question.
 * @property  \Illuminate\Support\Carbon $publication_date The data when the question was published.
 * @property  \Illuminate\Support\Carbon $expiration_date  The data when the question was expired.
 * @mixin \Eloquent
 */
class Question extends Model
{
    use SoftDeletes;
    use BlameableTrait; // Record author, updater and deleter
    use Sluggable; // Slugs
    use Taggable; // Tags
    use Presentable;

    /**
     * Defines question's statuses.
     */
    const DRAFT_STATUS = 'draft'; // Incomplete viewable by anyone with proper user role.
    const PUBLISH_STATUS = 'publish'; // Published.
    const PENDING_STATUS = 'pending'; // Awaiting a user with the publish_posts capability (typically a user assigned the Editor role) to publish.
    const FUTURE_STATUS = 'future';  // Scheduled to be published in a future date.
    /**
     * Defines question's types.
     */
    const SINGLE_RESPONSE_TYPE = 'single'; // Only one answer is correct.

    const MULTI_RESPONSE_TYPE = 'multi'; // Multiple answers are correct.

    /**
     * Model presenter.
     *
     * @var string
     */
    protected $presenter = QuestionPresenter::class;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'question',
        'solution',
        'type',
        'hidden',
        'publication_date',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'publication_date',
        'expiration_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'short_name' => 'string',
        'question' => 'string',
        'solution' => 'string',
        'type' => 'string',
        'hidden' => 'bool',
        'status' => 'string',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'short_name' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * A question will have some actions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions()
    {
        return $this->hasMany('Gamify\QuestionAction');
    }

    /**
     * A question will have some choices.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function choices()
    {
        return $this->hasMany('Gamify\QuestionChoice');
    }

    /**
     * Return the excerpt of the question text.
     *
     * @param int    $length
     * @param string $trailing
     *
     * @return string
     */
    public function excerpt($length = 55, $trailing = '...'): string
    {
        return ($length > 0) ? Str::words($this->question, $length, $trailing) : '';
    }

    /**
     * Get the list of actions that has not been selected yet.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableActions()
    {
        $selectedActions = $this->actions()->pluck('badge_id')->toArray();

        return Badge::whereNotIn('id', $selectedActions)->get();
    }

    /**
     * Returns true if question has been published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->status == self::PUBLISH_STATUS;
    }

    /**
     * Returns true if question has been published or scheduled.
     *
     * @return bool
     */
    public function isPublishedOrScheduled(): bool
    {
        return ($this->status == self::PUBLISH_STATUS) || ($this->status == self::FUTURE_STATUS);
    }

    /**
     * Returns published Questions, including hidden ones.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::PUBLISH_STATUS);
    }

    /**
     * Returns visible Questions, not hidden ones.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('hidden', false);
    }

    /**
     * Return if a question can be published.
     * 1. It has at least to choices
     * 2. It has at least one correct choice.
     *
     * @return bool
     */
    public function canBePublished(): bool
    {
        $answers_count = $this->choices()->count();
        $answers_correct_count = $this->choices()->correct()->count();

        return ($answers_count > 1) && ($answers_correct_count > 0);
    }

    /**
     * Returns the Badges that can be actionable depending if the answer was correct or not.
     *
     * @param bool $correctness
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActionableBadgesForCorrectness(bool $correctness = false): Collection
    {
        $filter = ($correctness === true) ? QuestionActuators::OnQuestionCorrectlyAnswered : QuestionActuators::OnQuestionIncorrectlyAnswered;

        $actionable_actions = $this->actions()
            ->whereIn('when', [QuestionActuators::OnQuestionAnswered, $filter])
            ->pluck('badge_id')
            ->toArray();

        return Badge::whereIn('id', $actionable_actions)
            ->get();
    }

    /**
     * Publishes or schedules a question using transitions to desired status.
     * It verifies all requirements before it.
     *
     * @throws \Gamify\Exceptions\QuestionPublishingException
     */
    public function publish(): void
    {
        if ($this->status == self::PUBLISH_STATUS) {
            return;
        }

        if (! $this->canBePublished()) {
            throw new QuestionPublishingException();
        }

        try {
            (is_null($this->publication_date) || $this->publication_date->lessThanOrEqualTo(now()))
                ? $this->transitionToPublishedStatus()
                : $this->transitionToScheduledStatus();
        } catch (\Throwable $exception) {
            throw new QuestionPublishingException($exception);
        }
    }

    /**
     * Transits a question to self::DRAFT_STATUS status.
     *
     * @throws \Throwable
     */
    public function transitionToDraftStatus(): void
    {
        if ($this->status == self::DRAFT_STATUS) {
            return;
        }

        // TODO: Remove all answers?

        $this->status = self::DRAFT_STATUS;
        $this->publication_date = null;
        $this->saveOrFail(); // throws exception on error
    }

    /**
     * Transits a question to self::PENDING_STATUS status.
     *
     * @throws \Gamify\Exceptions\QuestionPublishingException
     * @throws \Throwable
     */
    public function transitionToPendingStatus(): void
    {
        if ($this->status == self::PENDING_STATUS) {
            return;
        }

        if (! $this->canBePublished()) {
            throw new QuestionPublishingException();
        }

        $this->status = self::PENDING_STATUS;
        $this->publication_date = null;
        $this->saveOrFail(); // throws exception on error

        QuestionPendingReview::dispatch($this);
    }

    /**
     * Transits the question to self::PUBLISH_STATUS status.
     * Requirements have been verified before, send events once is published.
     *
     * @throws \Throwable
     * @see \Gamify\Question::publish()
     */
    private function transitionToPublishedStatus(): void
    {
        $this->status = self::PUBLISH_STATUS;
        $this->publication_date = now();
        $this->saveOrFail(); // throws exception on error

        QuestionPublished::dispatch($this);
    }

    /**
     * Transits the question to self:FUTURE_STATUS status.
     * Requirements have been verified before.
     *
     * @throws \Throwable
     * @see \Gamify\Question::publish()
     */
    private function transitionToScheduledStatus(): void
    {
        $this->status = self::FUTURE_STATUS;
        $this->saveOrFail(); // throws exception on error
    }
}
