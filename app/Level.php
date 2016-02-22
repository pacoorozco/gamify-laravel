<?php

namespace Gamify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Image uploads
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

// Theme support
use igaster\laravelTheme\Theme;

class Level extends Model implements StaplerableInterface
{
    use SoftDeletes;
    use EloquentTrait; // Image Uploads

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'levels';
    protected $fillable = array(
        'name',
        'image',
        'amount_needed',
        'active'
    );

    protected $dates = array('deleted_at');

    public function __construct(array $attributes = array())
    {
        $this->hasAttachedFile('image', [
            'styles' => [
                'big' => '220x220',
                'medium' => '128x128',
                'small' => '64x64'
            ],
            'url' => '/uploads/:class/:id_partition/:style/:filename',
            'default_url' => '/images/missing_level.png'
        ]);

        parent::__construct($attributes);
    }
}
