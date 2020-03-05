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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * Class Question.
 *
 *
 * @property  int    $id         The object unique id.
 * @property  string $name       The name of the question.
 * @property  string $short_name The slugged name of the question.
 * @property  string $question   The text for the question.
 * @property  string $solution   The test for the solution.
 * @property  string $type       The question type ['single'. 'multi'].
 * @property  bool   $hidden     The visibility of the question.
 * @property  string $status     The status of the question ['draft', 'publish', 'pending', 'private', 'future].
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
    const PUBLISH_STATUS = 'publish'; // Viewable by everyone.
    const PENDING_STATUS = 'pending'; // Awaiting a user with the publish_posts capability (typically a user assigned the Editor role) to publish.
    const PRIVATE_STATUS = 'private'; // Viewable only to administrators.
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
     * @param $query
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopePublished($query)
    {
        return $query->where('status', '=', self::PUBLISH_STATUS);
    }

    /**
     * Returns published Questions, only visible ones.
     *
     * @param $query
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopePublishedAndVisible($query)
    {
        return $query->where('status', '=', self::PUBLISH_STATUS)->where('hidden', false);
    }

    /**
     * Return if a question can be published.
     * 1. Has at least one correct answer.
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
     * Returns Image URL.
     *
     * @return string
     */
    public function getImageURL(): string
    {
        return asset('images/missing_question.png');
    }
}
