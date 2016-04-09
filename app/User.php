<?php

namespace Gamify;

use Carbon\Carbon;
use Gamify\Traits\GamificationTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Hash;

class User extends Model implements
AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, GamificationTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Mutator to hash the password automatically.
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Users have one user "profile".
     *
     * @return Model
     */
    public function profile()
    {
        return $this->hasOne('Gamify\UserProfile');
    }

    /**
     * Returns last logged in date.
     *
     * @return string
     */
    public function getLastLoggedDate()
    {
        if (!$this->last_login) {
            return 'Never';
        }
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->last_login);

        return $date->diffInMonths() >= 1 ? $date->format('j M Y , g:ia') : $date->diffForHumans();
    }

    /**
     * Returns a collection of users that are "Members".
     *
     * @param $query
     *
     * @return Collection
     */
    public function scopeMember($query)
    {
        return $query->where('role', '=', 'default');
    }
}
