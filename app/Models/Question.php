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

namespace Gamify\Models;

use Carbon\Carbon;
use Coderflex\LaravelPresenter\Concerns\CanPresent;
use Coderflex\LaravelPresenter\Concerns\UsesPresenters;
use Cviebrock\EloquentTaggable\Taggable;
use Gamify\Events\QuestionPendingReview;
use Gamify\Events\QuestionPublished;
use Gamify\Exceptions\QuestionPublishingException;
use Gamify\Presenters\QuestionPresenter;
use Gamify\Services\HashIdService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Throwable;

/**
 * Class Question.
 *
 * @property-read int $id The object unique id.
 * @property string $name The name of the question.
 * @property string $question The text for the question.
 * @property string $solution The text for the solution.
 * @property string $type The question type ['single'. 'multi'].
 * @property bool $hidden The visibility of the question.
 * @property string $status The status of the question.
 * @property-read string $hash The unique hash of this question.
 * @property-read string $slug The title's slug of this question.
 * @property-read User $creator The User who created this question,
 * @property-read User $updater The last User who updated this question.
 * @property Carbon|null $publication_date The data when the question was published.
 * @property Carbon|null $expiration_date The data when the question was expired.
 *
 * @mixin Model
 */
class Question extends Model implements CanPresent
{
    use SoftDeletes;
    use Taggable;
    use HasFactory;
    use UsesPresenters;
    use BlameableTrait;

    const DRAFT_STATUS = 'draft'; // Incomplete viewable by anyone with proper user role.

    const PUBLISH_STATUS = 'publish'; // Published.

    const PENDING_STATUS = 'pending'; // Awaiting a user with the publish_posts capability (typically a user assigned the Editor role) to publish.

    const FUTURE_STATUS = 'future';  // Scheduled to be published in a future date.

    const SINGLE_RESPONSE_TYPE = 'single'; // Only one answer is correct.

    const MULTI_RESPONSE_TYPE = 'multi'; // Multiple answers are correct.

    protected array $presenters = [
        'default' => QuestionPresenter::class,
    ];

    protected $fillable = [
        'name',
        'question',
        'solution',
        'type',
        'hidden',
        'publication_date',
    ];

    protected $casts = [
        'hidden' => 'bool',
        'publication_date' => 'datetime',
        'expiration_date' => 'datetime',

    ];

    public function excerpt(int $length = 55, string $trailing = '...'): string
    {
        return ($length > 0) ? Str::words($this->question, $length, $trailing) : '';
    }

    public function isPublished(): bool
    {
        return $this->status == self::PUBLISH_STATUS;
    }

    public function isScheduled(): bool
    {
        return $this->status == self::FUTURE_STATUS;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::PUBLISH_STATUS);
    }

    public function scopeScheduled(Builder $query): Builder
    {
        return $query
            ->where('status', self::FUTURE_STATUS)
            ->whereNotNull('publication_date');
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('hidden', false);
    }

    /**
     * Publishes or schedules a question using transitions to desired status.
     * It verifies all requirements before it.
     *
     * @throws QuestionPublishingException
     */
    public function publish(): void
    {
        if ($this->status == self::PUBLISH_STATUS) {
            return;
        }

        if ($this->canBePublished() === false) {
            throw new QuestionPublishingException('Question does not meet the publication requirements');
        }

        (is_null($this->publishedAt()) || $this->publishedAt()->lessThanOrEqualTo(now()))
            ? $this->transitionToPublishedStatus()
            : $this->transitionToScheduledStatus();

    }

    /**
     * Return if a question can be published.
     * 1. It has at least to choices
     * 2. It has at least one correct choice.
     */
    public function canBePublished(): bool
    {
        $answers_count = $this->choices()->count();
        // @phpstan-ignore-next-line
        $answers_correct_count = $this->choices()->correct()->count();

        return ($answers_count > 1) && ($answers_correct_count > 0);
    }

    public function choices(): HasMany
    {
        return $this->hasMany(QuestionChoice::class);
    }

    public function publishedAt(): ?Carbon
    {
        return $this->publication_date;
    }

    /**
     * Transits the question to self::PUBLISH_STATUS status.
     * Requirements have been verified before, send events once is published.
     *
     * @see Question::publish
     */
    private function transitionToPublishedStatus(): void
    {
        if ($this->status == self::PUBLISH_STATUS) {
            return;
        }

        $this->status = self::PUBLISH_STATUS;
        $this->publication_date = now();
        $this->save();

        QuestionPublished::dispatch($this);
    }

    /**
     * Transits the question to self:FUTURE_STATUS status.
     * Requirements have been verified before.
     *
     * @see Question::publish
     */
    private function transitionToScheduledStatus(): void
    {
        if ($this->status == self::FUTURE_STATUS) {
            return;
        }

        $this->status = self::FUTURE_STATUS;
        $this->save();
    }

    /**
     * Transits a question to self::DRAFT_STATUS status.
     *
     * @throws Throwable
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
     * @throws QuestionPublishingException
     * @throws Throwable
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

    protected function hash(): Attribute
    {
        return Attribute::make(
            get: fn () => ((new HashIdService())->encode($this->id)),
        );
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::slug($this->name),
        );
    }
}
