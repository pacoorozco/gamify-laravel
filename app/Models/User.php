<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Gamify\Models;

use Gamify\Enums\Roles;
use Gamify\Presenters\UserPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laracodes\Presenter\Traits\Presentable;

/**
 * User model, represents a Gamify user.
 *
 * @property int $id The object unique id.
 * @property string $name The name of this user.
 * @property string $username The username of this user.
 * @property string $email The email address of this user.
 * @property string $password Encrypted password of this user.
 * @property \Gamify\Enums\Roles $role Role of the user.
 * @property int $experience The reputation of the user.
 */
class User extends Authenticatable
{
    use HasFactory;
    use Presentable;

    protected string $presenter = UserPresenter::class;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'email_verified_at',
    ];

    protected $casts = [
        'role' => Roles::class,
    ];

    public static function findByUsername(string $username): self
    {
        return static::where('username', $username)->firstOrFail();
    }

    public static function findByEmailAddress(string $emailAddress): self
    {
        return static::where('email', $emailAddress)->firstOrFail();
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * These are the User's Points relationship.
     *
     * Results are grouped by user_is and it selects the sum of all points
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points(): HasMany
    {
        return $this->hasMany(Point::class)
            ->selectRaw('sum(points) as sum, user_id')
            ->groupBy('user_id');
    }

    public function isAdmin(): bool
    {
        return $this->role->is(Roles::Admin);
    }

    public function scopePlayer(Builder $query): Builder
    {
        return $query->where('role', Roles::Player);
    }

    /**
     * Linked Social Accounts (facebook, twitter, github...).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    public function pendingQuestions(int $limit = 5): Collection
    {
        $answeredQuestions = $this->answeredQuestions()->pluck('question_id')->toArray();

        return Question::published()->visible()
            ->whereNotIn('id', $answeredQuestions)
            ->orderBy('publication_date', 'ASC')
            ->take($limit)
            ->get();
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
    public function answeredQuestions(): BelongsToMany
    {
        return $this->belongsToMany('Gamify\Models\Question', 'users_questions', 'user_id', 'question_id')
            ->withPivot('points', 'answers');
    }

    public function getCompletedBadges(): Collection
    {
        return $this->badges()
            ->wherePivot('completed', true)
            ->get();
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
    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(
            Badge::class,
            'users_badges',
            'user_id',
            'badge_id')
            ->withPivot('repetitions', 'completed', 'completed_on');
    }

    public function hasBadgeCompleted(Badge $badge): bool
    {
        return $this->badges()
            ->wherePivot('badge_id', $badge->id)
            ->wherePivot('completed', true)
            ->exists();
    }

    protected function username(): Attribute
    {
        return Attribute::make(
            set: fn($value) => strtolower($value),
        );
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Hash::make($value),
        );
    }

    protected function level(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Level::findByExperience($this->experience)
                ->name,
        );
    }

    protected function nextLevel(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->getNextLevel()->name
        );
    }

    private function getNextLevel(): Level
    {
        return Level::findNextByExperience($this->experience)
            ?? Level::findByExperience($this->experience);
    }
}
