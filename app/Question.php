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
use Gamify\Events\QuestionPublished;
use Gamify\Exceptions\InvalidContentForPublicationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
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
 * @property  string                     $status           The status of the question ['draft', 'publish', 'pending',
 *            'private', 'future].
 * @property  string                     $public_url       The public URL of this question.
 * @property  \Gamify\User               $creator          The User who created this question,
 * @property  \Gamify\User               $updater          The last User who updated this question.
 * @property  \Illuminate\Support\Carbon $publication_date The data when the question was published.
 * @property  \Illuminate\Support\Carbon $expiration_date  The data when the question was expired.
 */
class Question extends Model
{
    use SoftDeletes;
    use BlameableTrait; // Record author, updater and deleter

    use Sluggable; // Slugs

    use Taggable; // Tags

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
        'status',
        'publication_date',
    ];

    protected $dates = [
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
     * Returns the public URL of this question.
     *
     * @return string
     */
    public function getPublicUrlAttribute(): string
    {
        return route('questions.show', ['questionname' => $this->short_name]);
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
        $answers_correct_count = $this->choices()->where('correct', true)->count();

        return ($answers_count > 1) && ($answers_correct_count > 0);
    }

    /**
     * Publish the question and trigger events.
     *
     * @throws \Gamify\Exceptions\InvalidContentForPublicationException
     * @throws \Throwable
     */
    public function publish(): void
    {
        if ($this->status === self::PUBLISH_STATUS) {
            return;
        }

        $this->status = ($this->publication_date > now())
            ? self::FUTURE_STATUS
            : self::PUBLISH_STATUS;

        if (!$this->canBePublished()) {
            throw new InvalidContentForPublicationException();
        }

        $this->saveOrFail(); // throws exception on error

        QuestionPublished::dispatch($this);
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
        $filter = ($correctness === true) ? QuestionAction::ON_SUCCESS : QuestionAction::ON_FAILURE;

        $actionable_actions = $this->actions()
            ->whereIn('when', [QuestionAction::ON_ANY_CASE, $filter])
            ->pluck('badge_id')
            ->toArray();

        return Badge::whereIn('id', $actionable_actions)
            ->get();
    }

    public function transitionToDraftStatus(): bool
    {
        if ($this->status == self::DRAFT_STATUS) {
            return true;
        }

        // TODO: Remove all answers?

        $this->status = self::DRAFT_STATUS;
        $this->publication_date = null;
        $this->expiration_date = null;

        return $this->save();
    }

    public function transitionToPendingStatus(): bool
    {
        if ($this->status == self::PENDING_STATUS) {
            return true;
        }

        if ($this->status != self::DRAFT_STATUS) {
            return false; // Only draft -> pending transition is allowed
        }

        // TODO: Broadcast new pending question is available to editors

        $this->status = self::PENDING_STATUS;

        return $this->save();
    }

    public function transitionToPublishStatus(): bool
    {
        if ($this->status == self::PUBLISH_STATUS) {
            return true;
        }

        // TODO: Check question is ready to be published or false

        $this->status = self::PUBLISH_STATUS;
        $this->publication_date = now();

        return $this->save();
    }

    public function transitionToFutureStatus(): bool
    {
        if ($this->status != self::DRAFT_STATUS) {
            return false; // Only draft -> future transition is allowed
        }

        if (is_null($this->publication_date) || $this->publication_date->lessThanOrEqualTo(now())) {
            return false; // Can not schedule for a past date
        }

        // TODO: Check question is ready to be published or false

        $this->status = self::FUTURE_STATUS;

        return $this->save();
    }
}
