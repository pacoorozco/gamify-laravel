<?php

namespace Gamify;

use Codesleeve\Stapler\ORM\EloquentTrait;
// Image uploads
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model implements StaplerableInterface
{
    use EloquentTrait; // Image Uploads

    /**
     * The database table used by the model.
     */
    protected $table = 'user_profiles';
    protected $fillable = [
        'avatar',
        'bio',
        'url',
        'phone',
        'mobile',
        'date_of_birth',
        'gender',
        'twitter',
        'facebook',
        'googleplus',
        'linkedin',
        'github',
    ];

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('avatar', [
            'styles' => [
                'big'    => '220x220',
                'medium' => '150x150',
                'small'  => '64x64',
            ],
            'url'         => '/uploads/:class/:id_partition/:style/:filename',
            'default_url' => '/images/missing_profile.png',
        ]);

        parent::__construct($attributes);
    }

    public function user()
    {
        return $this->belongsTo('Gamify\User');
    }
}
