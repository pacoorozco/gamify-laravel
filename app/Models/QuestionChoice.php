<?php

namespace Gamify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionChoice.
 *
 * @property string $text    The text of this choice.
 * @property int $score   How many points are added by this choice.
 * @mixin \Eloquent
 * @property-read \Gamify\Models\Question $question
 * @method static \Illuminate\Database\Eloquent\Builder|\Gamify\QuestionChoice correct()
 */
class QuestionChoice extends Model
{

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
    public function question()
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
     *
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
     *
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
     * @deprecated
     */
    public function getCorrectAttribute(): bool
    {
        return $this->isCorrect();
    }
}
