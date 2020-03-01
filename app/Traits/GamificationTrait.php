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

namespace Gamify\Traits;

use Gamify\Badge;
use Gamify\Level;
use Gamify\Question;

trait GamificationTrait
{
    /**
     * Get current Level name for this user.
     *
     * @return string
     */
    public function getCurrentLevelName()
    {
        return Level::fromExperience($this->getExperiencePoints())->name;
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
        $experienceUntilLevel = $level->required_points - $experience;

        return $experienceUntilLevel <= 0;
    }

    /**
     * Return the next Level (object) for this user.
     *
     * @return Level
     */
    public function getNextLevel()
    {
        return Level::nextFromExperience($this->getExperiencePoints());
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

        return $level->required_points - $experience;
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

    public function getPendingQuestions()
    {
        // TODO: Add an scope to only index questions (published and not answered and not hidden)
        $answeredQuestions = $this->answeredQuestions()->pluck('question_id')->toArray();

        return Question::PublishedAndVisible()->whereNotIn('id', $answeredQuestions)->get();
    }
}
