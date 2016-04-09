<?php

namespace Gamify;

use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
// Image uploads
use igaster\laravelTheme\Theme;
use Illuminate\Database\Eloquent\Model;
// Theme support
use Illuminate\Database\Eloquent\SoftDeletes;

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
    protected $fillable = [
        'name',
        'image',
        'amount_needed',
        'active',
    ];

    protected $dates = ['deleted_at'];

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('image', [
            'styles' => [
                'big'    => '220x220',
                'medium' => '128x128',
                'small'  => '64x64',
            ],
            'url'         => '/uploads/:class/:id_partition/:style/:filename',
            'default_url' => '/images/missing_level.png',
        ]);

        parent::__construct($attributes);
    }
}
