<?php

namespace Gamify;

use Illuminate\Database\Eloquent\Model;

// Image uploads
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class UserProfile extends Model implements StaplerableInterface
{
    use EloquentTrait; // Image Uploads

    /**
     * The database table used by the model.
     */
    protected $table = 'user_profiles';
    protected $fillable = array(
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
        'skype',
    );

    /**
     * The validation rules for this model.
     */
    public static $rules = array(
        'url'      => 'url',
        'date_of_birth' => 'date',
        'gender'  => 'required|in:male,female,unspecified',
        'twitter'  => 'url',
        'facebook'  => 'url',
        'googleplus'  => 'url',
        'linkedin'  => 'url',
        'github'  => 'url',
    );

    public function __construct(array $attributes = array())
    {
        $this->hasAttachedFile('avatar', [
            'styles' => [
                'big' => '220x220',
                'medium' => '150x150',
                'small' => '64x64'
            ],
            'url' => '/uploads/:class/:id_partition/:style/:filename',
            'default_url' => '/img/missing_profile.png'
        ]);

        parent::__construct($attributes);
    }

    public function user()
    {
        return $this->belongsTo('Gamify\User');
    }
}
