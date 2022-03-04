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

    public $timestamps = false;

    protected $fillable = [
        'text',
        'score',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    protected $touches = ['question'];

    public function isCorrect(): bool
    {
        return $this->score > 0;
    }

    public function scopeCorrect(Builder $query): Builder
    {
        return $query->where('score', '>', '0');
    }

    public function scopeIncorrect(Builder $query): Builder
    {
        return $query->where('score', '<=', '0');
    }
}
