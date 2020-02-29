<?php

namespace Gamify;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionChoice
 *
 * @property  string $text    The text of this choice.
 * @property  bool   $correct Is this choice correct?.
 * @property  int    $score   How many points are added by this choice.
 */
class QuestionChoice extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'question_choices';

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
        'correct',
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
        'correct' => 'bool',
        'score' => 'int',
    ];

    /**
     * A question choice belongs to a question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('Gamify\Question');
    }

    /**
     * Every time we modify a choice we need to touch the question.
     */
    protected $touches = ['question'];
}
