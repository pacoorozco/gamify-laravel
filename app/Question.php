<?php

namespace Gamify;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Gamify\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// TODO: #1 Can't use EloquentTrait with RecordSignature
// Image uploads
// use Codesleeve\Stapler\ORM\StaplerableInterface;
// use Codesleeve\Stapler\ORM\EloquentTrait;

// Slugs for Eloquent Models

// Record created_by, updated_by

// TODO: #1 Can't use EloquentTrait with RecordSignature
// class Question extends Model implements StaplerableInterface, SluggableInterface {
class Question extends Model implements SluggableInterface {

    use SoftDeletes;
    use RecordSignature; // Record Signature
    // TODO: #1 Can't use EloquentTrait with RecordSignature
    // use EloquentTrait; // Image Uploads
    use SluggableTrait; // Slugs

    /**
     * The database table used by the model.
     */
    protected $table = 'questions';
    protected $fillable = array(
        'name',
        'image',
        'question',
        'solution',
        'type',
        'hidden',
        'status'
    );

    protected $dates = array('deleted_at');

    /**
     * The Question slug in order to implement permanent URL to questions
     */
    protected $sluggable = array(
        'build_from'      => 'name',
        'save_to'         => 'shortname',
        'include_trashed' => true,
    );

    /**
     * A question will have some choices
     */
    public function choices()
    {
        return $this->hasMany('Gamify\QuestionChoice');
    }

    /**
     * A question will have some actions
     */
    public function actions()
    {
        return $this->hasMany('Gamify\QuestionAction');
    }

    public function getAvailableActions()
    {
        $selectedActions = $this->actions()->lists('badge_id')->toArray();
        return Badge::whereNotIn('id', $selectedActions)->get();
    }

    // TODO: #1 Can't use EloquentTrait with RecordSignature
//    public function __construct(array $attributes = array())
//    {
//        $this->hasAttachedFile('image', [
//            'styles'      => [
//                'big'    => '220x220',
//                'medium' => '128x128',
//                'small'  => '64x64'
//            ],
//            'url'         => '/uploads/:class/:id_partition/:style/:filename',
//            'default_url' => 'images/missing_question.png'
//        ]);
//
//        parent::__construct($attributes);
//    }

    public function scopePublished($query)
    {
        return $query->where('status', '=', 'publish');
    }

    /**
     * Return if a question can be published.
     * 1. Has at least one correct answer
     *
     * @return bool
     */
    public function canBePublished()
    {
        $answers_count = $this->choices()->count();
        $answers_correct_count = $this->choices()->where('correct', true)->count();

        return (($answers_count > 1) && ($answers_correct_count > 0));
    }

    /**
     * Return the excerpt of the question text.
     * @param int $length
     * @param string $trailing
     * @return string
     */
    public function excerpt($length = 55, $trailing = '...')
    {
        $text = strip_tags($this->question);

        if (str_word_count($text, 0) > $length) {
            // string exceeded length, truncate and add trailing dots
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$length]) . $trailing;
        }
        // string was already short enough, return the string
        return '<p>' . $text . '</p>';
    }
}