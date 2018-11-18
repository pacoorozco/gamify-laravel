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
 * @link               https://github.com/pacoorozco/gamify-l5
 */

namespace Gamify;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentTaggable\Taggable;
use Gamify\Traits\RecordAuthorSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    use RecordAuthorSignature; // Record Signature
    use Sluggable; // Slugs
    use Taggable; // Tags

    protected $table = 'questions';
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
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'short_name'     => [
                'source' => 'name',
            ],
            'includeTrashed' => true,
        ];
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
     * A question will have some actions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions()
    {
        return $this->hasMany('Gamify\QuestionAction');
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
        return $query->where('status', '=', 'publish');
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
        return $query->where('status', '=', 'publish')->where('hidden', false);
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
        $text = strip_tags($this->question);

        if (str_word_count($text, 0) > $length) {
            // string exceeded length, truncate and add trailing dots
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$length]).$trailing;
        }
        // string was already short enough, return the string
        return '<p>'.$text.'</p>';
    }
}
