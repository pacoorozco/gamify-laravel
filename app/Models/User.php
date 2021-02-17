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

namespace Gamify\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

/**
 * User model, represents a Gamify user.
 *
 * @property  int                        $id                      The object unique id.
 * @property  string                     $name                    The name of this user.
 * @property  string                     $username                The username of this user.
 * @property  string                     $email                   The email address of this user.
 * @property  string                     $password                Encrypted password of this user.
 * @property  string                     $role                    Role of the user ['user', 'editor', 'administrator'].
 * @property  \Illuminate\Support\Carbon $last_login_at           Time when the user last logged in.
 * @property  int                        $experience              The reputation of the user.
 */
class User extends Authenticatable
{
    use HasFactory;

    /**
     * Define User's roles.
     */
    const USER_ROLE = 'user';
    const EDITOR_ROLE = 'editor';
    const ADMIN_ROLE = 'administrator';

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
        'experience' => 'int',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_login_at',
        'email_verified_at',
    ];

    /**
     * Users have one user "profile".
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * These are the User's answered Questions.
     *
     * It uses a pivot table with these values:
     *
     * points: int - how many points was obtained
     * answers: string - which answers was supplied
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function answeredQuestions()
    {
        return $this->belongsToMany('Gamify\Models\Question', 'users_questions', 'user_id', 'question_id')
            ->withPivot('points', 'answers');
    }

    /**
     * These are the User's Badges relationship.
     *
     * It uses a pivot table with these values:
     *
     * amount: int - how many actions has completed
     * completed: bool - true if User's has own this badge
     * completed_on: Datetime - where it was completed
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function badges()
    {
        return $this->belongsToMany(
            Badge::class,
            'users_badges',
            'user_id',
            'badge_id')
            ->withPivot('repetitions', 'completed', 'completed_on');
    }

    /**
     * These are the User's Points relationship.
     *
     * Results are grouped by user_is and it selects the sum of all points
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points()
    {
        return $this->hasMany(Point::class )
            ->selectRaw('sum(points) as sum, user_id')
            ->groupBy('user_id');
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
        return is_null($this->last_login_at) ? 'N/A' : $this->last_login_at->diffForHumans();
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
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMember(Builder $query)
    {
        return $query->where('role', self::USER_ROLE);
    }

    /**
     * Get current Experience points for this user.
     *
     * @return int
     */
    public function getExperiencePoints(): int
    {
        return $this->experience;
    }

    /**
     * Add experience to the user.
     *
     * Trigger ExperienceChanged event.
     *
     * @param int $points
     */
    public function addExperience(int $points = 1): void
    {
        $this->increment('experience', $points);

        // TODO: Dispatch event ReputationChanged
    }

    /**
     * Linked Social Accounts (facebook, twitter, github...).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    /**
     * Returns a Collection of pending Questions.
     *
     * @param int $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function pendingQuestions(int $limit = 5)
    {
        $answeredQuestions = $this->answeredQuestions()->pluck('question_id')->toArray();

        return Question::published()->visible()
            ->whereNotIn('id', $answeredQuestions)
            ->orderBy('publication_date', 'ASC')
            ->take($limit)
            ->get();
    }

    /**
     * Returns a Collection of completed Badges for this user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCompletedBadges()
    {
        return $this->badges()
            ->wherePivot('completed', true)
            ->get();
    }

    /**
     * Checks if user has completed the given Badge.
     *
     * @param \Gamify\Models\Badge $badge
     *
     * @return bool
     */
    public function hasBadgeCompleted(Badge $badge): bool
    {
        return $this->badges()
                ->wherePivot('badge_id', $badge->id)
                ->wherePivot('completed', true)
                ->get()
                ->count() > 0;
    }

    /**
     * Add Level name to attributes (see $appends).
     *
     * We rely that a default Level was created with required_points = 0;
     *
     * @return string
     */
    public function getLevelAttribute(): string
    {
        return Level::findByExperience($this->experience)->name;
    }

    /**
     * Get Next level name.
     *
     * @return string
     */
    public function getNextLevelAttribute(): string
    {
        return $this->getNextLevel()->name;
    }

    /**
     * Get the next Level object.
     *
     * @return \Gamify\Models\Level
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getNextLevel(): Level
    {
        try {
            return Level::findNextByExperience($this->experience);
        } catch (ModelNotFoundException $exception) {
            return Level::findByExperience($this->experience);
        }
    }
}
