<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 - 2020 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 - 2020 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Gamify;

use Carbon\Carbon;
use Gamify\Traits\GamificationTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

/**
 * User model, represents a Gamify user.
 *
 * @property  int    $id                      The object unique id.
 * @property  string $name                    The name of this user.
 * @property  string $username                The username of this user.
 * @property  string $email                   The email address of this user.
 * @property  string $password                Encrypted password of this user.
 * @property  string $role                    Role of the user ['user', 'editor', 'administrator'].
 * @property  string $last_login_at           Time when the user last logged in.
 */
class User extends Authenticatable
{
    use Notifiable;
    use GamificationTrait;

    /**
     * Define User's roles
     */
    const USER_ROLE = 'user';
    const EDITOR_ROLE = 'editor';
    const ADMIN_ROLE = 'administrator';

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
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'username' => 'string',
        'email' => 'string',
        'password' => 'string',
        'role' => 'string',
        'last_login_at' => 'datetime',
    ];

    /**
     * Users have one user "profile".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne('Gamify\UserProfile');
    }

    /**
     * Set the username attribute to lowercase.
     *
     * @param string $value
     */
    public function setUsernameAttribute(string $value)
    {
        $this->attributes['username'] = strtolower($value);
    }

    /**
     * Add a mutator to ensure hashed passwords.
     *
     * @param string $password
     */
    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Returns last logged in date in "x ago" format if it has passed less than a month.
     *
     * @return string
     */
    public function getLastLoggedDate(): string
    {
        if (empty($this->last_login_at)) {
            return __('general.never');
        }
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->last_login_at);

        if ($date->diffInMonths() >= 1) {
            return $date->format('j M Y, g:ia');
        }

        return $date->diffForHumans();
    }

    /**
     * Return true if user has 'administrator' role.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ADMIN_ROLE;
    }

    /**
     * Returns a collection of users that are "Members".
     *
     * @param $query
     *
     * @return \Illuminate\Support\Collection
     */
    public function scopeMember($query)
    {
        return $query->where('role', '=', self::USER_ROLE);
    }
}
