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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class QuestionChoice.
 *
 * @property string $text The text of this choice.
 * @property int $score How many points are added by this choice.
 * @mixin \Eloquent
 *
 * @property-read \Gamify\Models\Question $question
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Gamify\Models\QuestionChoice correct()
 */
class QuestionChoice extends Model
{
    use HasFactory;

    /**
     * Disable the timestamps on this model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text',
        'score',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'text' => 'string',
        'score' => 'int',
    ];

    /**
     * A question choice belongs to a question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Every time we modify a choice we need to touch the question.
     */
    protected $touches = ['question'];

    /**
     * Returns true if the choice is considered correct.
     *
     * @return bool
     */
    public function isCorrect(): bool
    {
        return $this->score > 0;
    }

    /**
     * Return question choices considered as correct.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCorrect(Builder $query): Builder
    {
        return $query->where('score', '>', '0');
    }

    /**
     * Return question choices considered as incorrect.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncorrect(Builder $query): Builder
    {
        return $query->where('score', '<=', '0');
    }

    /**
     * DEPRECATED: Use isCorrect() instead.
     *
     * @return bool
     *
     * @deprecated
     */
    public function getCorrectAttribute(): bool
    {
        return $this->isCorrect();
    }
}
