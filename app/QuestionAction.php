<?php

namespace Gamify;

use Illuminate\Database\Eloquent\Model;

class QuestionAction extends Model
{
    protected $table = 'question_actions';

    public $timestamps = false;

    protected $fillable = array(
        'when',
    );

    /**
     * Every time we modify an action we need to touch the question
     */
    protected $touches = array('question');

    /**
     * A question action belongs to a question
     */
    public function question()
    {
        return $this->belongsTo('Gamify\Question');
    }
}
