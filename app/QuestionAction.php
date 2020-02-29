<?php

namespace Gamify;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionAction.
 *
 * @property  string $when     This is when this action will be triggered ['success', 'fail', 'always'].
 * @property  int    $badge_id This Badge will be associated once you complete the action.
 */
class QuestionAction extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'question_actions';

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
        'when',
        'badge_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'when' => 'string',
        'badge_id' => 'int',
    ];

    /**
     * A question action belongs to a question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('Gamify\Question');
    }

    /**
     * Every time we modify an action we need to touch the question.
     */
    protected $touches = ['question'];

    /**
     * Returns the name of the associated Badge.
     *
     * @return string
     */
    public function getName(): string
    {
        $badge = Badge::find($this->badge_id);

        return $badge->name;
    }
}
