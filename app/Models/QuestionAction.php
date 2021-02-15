<?php

namespace Gamify\Models;

use Gamify\Enums\BadgeActuators;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionAction.
 *
 * @property  string $when     This is when this action will be triggered (@see BadgeActuators::getActuatorsForQuestions().
 * @property  int    $badge_id This Badge will be associated once you complete the action.
 */
class QuestionAction extends Model
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
        'when' => 'int',
        'badge_id' => 'int',
    ];

    /**
     * A question action belongs to a question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Every time we modify an action we need to touch the question.
     */
    protected $touches = ['question'];
}
