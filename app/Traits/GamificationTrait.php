<?php

namespace Gamify\Traits;

use Gamify\Badge;
use Gamify\Level;
use Gamify\Question;
use Illuminate\Database\Eloquent\Relations\Relation;

trait GamificationTrait
{
    /**
     * These are the User's answered Questions.
     *
     * It uses a pivot table with these values:
     *
     * points: int - how many points was obtained
     * answers: string - which answers was supplied
     *
     * @return Relation
     */
    public function answeredQuestions()
    {
        return $this->belongsToMany('Gamify\Question', 'users_questions', 'user_id', 'question_id')
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
     * @return Relation
     */
    public function badges()
    {
        return $this->belongsToMany('Gamify\Badge', 'users_badges', 'user_id', 'badge_id')
            ->withPivot('amount', 'completed', 'completed_on');
    }

    /**
     * These are the User's Points relationship.
     *
     * Results are grouped by user_is and it selects the sum of all points
     *
     * @return Relation
     */
    public function points()
    {
        return $this->hasMany('Gamify\Point')
            ->selectRaw('sum(points) as sum, user_id')
            ->groupBy('user_id');
    }

    /**
     * Get current Level (object) for this user.
     *
     * @return Level
     */
    public function getLevel()
    {
        $experience = $this->getExperiencePoints();

        return Level::where('amount_needed', '<=', $experience)->orderBy('amount_needed')->first();
    }

    /**
     * Get current Level name for this user.
     *
     * @return string
     */
    public function getLevelName()
    {
        $level = $this->getLevel();

        return $level->name;
    }

    /**
     * Check if user is at least level $level.
     *
     * @param Level $level
     *
     * @return bool
     */
    public function atLeastLevel(Level $level)
    {
        $experience = $this->getExperiencePoints();
        $experienceUntilLevel = $level->ammount_needed - $experience;

        return $experienceUntilLevel <= 0;
    }

    /**
     * Return the next Level (object) for this user.
     *
     * @return Level
     */
    public function getNextLevel()
    {
        $experience = $this->getExperiencePoints();

        return Level::where('amount_needed', '>', $experience)->orderBy('amount_needed')->first();
    }

    /**
     * Returns how many Experience Points until next Level.
     *
     * @return int
     */
    public function experienceUntilNextLevel()
    {
        $nextLevel = $this->getNextLevel();

        return $this->experienceUntilLevel($nextLevel);
    }

    /**
     * Returns how many experience points needs until a desired level.
     *
     * @param Level $level
     *
     * @return int
     */
    public function experienceUntilLevel(Level $level)
    {
        $experience = $this->getExperiencePoints();

        return $level->amount_needed - $experience;
    }

    /**
     * Get current Experience points for this user.
     *
     * @return int
     */
    public function getExperiencePoints()
    {
        return $this->points()->sum('points');
    }

    /**
     * Checks if user has the given Badge.
     *
     * @param Badge $badge
     *
     * @return bool
     */
    public function hasBadgeCompleted(Badge $badge)
    {
        $userBadge = $this->badges()->find($badge->id);

        return $userBadge->pivot->completed;
    }

    /**
     * Returns a Collection of completed Badges for this user.
     *
     * @return mixed
     */
    public function getCompletedBadges()
    {
        return $this->badges()->wherePivot('completed', true)->get();
    }

    public function getPendingQuestions()
    {
        // TODO: Add an scope to only index questions (published and not answered and not hidden)
        $answeredQuestions = $this->answeredQuestions()->pluck('question_id')->toArray();

        return Question::PublishedAndVisible()->whereNotIn('id', $answeredQuestions)->get();
    }
}
