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

use Coderflex\LaravelPresenter\Concerns\CanPresent;
use Coderflex\LaravelPresenter\Concerns\UsesPresenters;
use Gamify\Enums\Roles;
use Gamify\Presenters\UserPresenter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

/**
 * User model, represents a Gamify user.
 *
 * @property string $name The name of this user.
 * @property string $username The username of this user.
 * @property string $email The email address of this user.
 * @property string $password Encrypted password of this user.
 * @property Roles $role Role of the user.
 * @property UserProfile $profile The user's profile
 * @property-read int $id The object unique id.
 * @property-read int $experience The experience points of the user.
 * @property-read string $level The current level of the user.
 * @property-read Collection $unreadNotifications The user's unread notifications.
 */
final class User extends Authenticatable implements MustVerifyEmail, CanPresent
{
    use HasFactory;
    use Notifiable;
    use UsesPresenters;

    protected array $presenters = [
        'default' => UserPresenter::class,
    ];

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

    protected $casts = [
        'level' => Level::class,
        'role' => Roles::class,
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return $this->role->is(Roles::Admin);
    }

    public function scopePlayer(Builder $query): Builder
    {
        return $query->where('role', Roles::Player);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Linked Social Accounts (facebook, twitter, github...).
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }

    public function nextLevelCompletionPercentage(): int
    {
        $nextLevel = $this->nextLevel();

        if ($nextLevel->required_points === 0) {
            return 100;
        }

        $completion = min(($this->experience / $nextLevel->required_points) * 100, 100);

        return (int) $completion;
    }

    public function nextLevel(): Level
    {
        return Level::findNextByExperience($this->experience);
    }

    public function pointsToNextLevel(): int
    {
        $pointsToNextLevel = $this->nextLevel()->required_points - $this->experience;

        return max($pointsToNextLevel, 0);
    }

    public function pendingQuestions(int $perPageLimit = 5, bool $filterHiddenQuestions = true): Paginator
    {
        $answeredQuestions = $this->answeredQuestions()
            ->pluck('question_id')
            ->toArray();

        return Question::query()
            ->published()
            ->whereNotIn('id', $answeredQuestions)
            ->when($filterHiddenQuestions, fn ($query) => $query->public())
            ->inRandomOrder()
            ->simplePaginate($perPageLimit);
    }

    /**
     * These are the User's answered Questions.
     *
     * It uses a pivot table with these values:
     *
     * points: int - how many points was obtained
     * answers: string - which answers was supplied
     */
    public function answeredQuestions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'users_questions')
            ->as('response')
            ->withPivot(['points', 'answers'])
            ->using(UserResponse::class);
    }

    public function answeredQuestionsCount(): int
    {
        return $this->answeredQuestions()->count();
    }

    public function hasAnsweredQuestion(Question $question): bool
    {
        return $this->answeredQuestions()
            ->where('question_id', $question->id)
            ->exists();
    }

    public function getResponseForQuestion(Question $question): ?UserResponse
    {
        return $this->answeredQuestions()
            ->where('question_id', $question->id)
            ->first()
            ->response ?? null;
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'users_badges')
            ->as('progress')
            ->withPivot(['repetitions', 'unlocked_at'])
            ->using(UserBadgeProgress::class);
    }

    public function progressToCompleteTheBadge(Badge $badge): ?UserBadgeProgress
    {
        return $this->badges()
            ->wherePivot('badge_id', $badge->id)
            ->first()
            ->progress ?? null;
    }

    public function unlockedBadges(): Collection
    {
        return $this->badges()
            ->wherePivotNotNull('unlocked_at')
            ->get();
    }

    public function unlockedBadgesCount(): int
    {
        return $this->unlockedBadges()->count();
    }

    public function lockedBadges(): Collection
    {
        return $this->badges()
            ->wherePivotNull('unlocked_at')
            ->get();
    }

    public function hasUnlockedBadge(Badge $badge): bool
    {
        return $this->badges()
            ->wherePivot('badge_id', $badge->id)
            ->wherePivotNotNull('unlocked_at')
            ->exists();
    }

    public function hasLockedBadge(Badge $badge): bool
    {
        return $this->badges()
            ->wherePivot('badge_id', $badge->id)
            ->wherePivotNull('unlocked_at')
            ->exists();
    }

    /**
     * Ensure username is stored in lower cases.
     */
    protected function username(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value),
        );
    }

    /**
     * Ensure password is stored encrypted.
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value),
        );
    }

    protected function level(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Level::findByExperience($this->experience)
                ->name,
        );
    }

    protected function experience(): Attribute
    {
        return Attribute::make(
            get: fn () => Cache::remember('user_experience_'.$this->id, 600, function () {
                return $this->points()->sum('points');
            })
        );
    }
}
