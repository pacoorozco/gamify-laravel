<?php

namespace Gamify;

use Illuminate\Database\Eloquent\Model;

class QuestionChoice extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'question_choices';

    public $timestamps = false;

    protected $fillable = [
        'text',
        'correct',
        'score',
    ];

    /**
     * Every time we modify a choice we need to touch the question.
     */
    protected $touches = ['question'];

    /**
     * A question choice belongs to a question.
     */
    public function question()
    {
        return $this->belongsTo('Gamify\Question');
    }
}
