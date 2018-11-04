<?php

namespace Gamify;

use Conner\Tagging\Taggable;
use Gamify\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Question extends Model
{
    use SoftDeletes;
    use RecordSignature; // Record Signature
    use Sluggable; // Slugs
    use Taggable; // Tags

    /**
     * The database table used by the model.
     */
    protected $table = 'questions';
    protected $fillable = [
        'name',
        'question',
        'solution',
        'type',
        'hidden',
        'status',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'shortname' => [
                'source' => 'name'
            ],
            'includeTrashed' => true
        ];
    }

    /**
     * A question will have some choices.
     */
    public function choices()
    {
        return $this->hasMany('Gamify\QuestionChoice');
    }

    /**
     * A question will have some actions.
     */
    public function actions()
    {
        return $this->hasMany('Gamify\QuestionAction');
    }

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
     * @return mixed
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
     * @return mixed
     */
    public function scopePublishedAndVisible($query)
    {
        return $query->where('status', '=', 'publish')->where('hidden', false);
    }

    /**
     * Get a list of tags ids associated with the current Question.
     *
     * @return array
     */
    public function getTagListAttribute()
    {
        return $this->tagged->pluck('tag_slug')->all();
    }

    /**
     * Return if a question can be published.
     * 1. Has at least one correct answer.
     *
     * @return bool
     */
    public function canBePublished()
    {
        $answers_count = $this->choices()->count();
        $answers_correct_count = $this->choices()->where('correct', true)->count();

        return ($answers_count > 1) && ($answers_correct_count > 0);
    }

    /**
     * Return the excerpt of the question text.
     *
     * @param int    $length
     * @param string $trailing
     *
     * @return string
     */
    public function excerpt($length = 55, $trailing = '...')
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
