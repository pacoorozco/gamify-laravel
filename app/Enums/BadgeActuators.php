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

namespace Gamify\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\FlaggedEnum;
use Illuminate\Support\Arr;

enum BadgeActuators : int
{
    /** Actuators based on question's events */
    case OnQuestionAnswered = 1 << 0;
    case OnQuestionCorrectlyAnswered = 1 << 1;
    case OnQuestionIncorrectlyAnswered = 1 << 2;
    /** Actuators based on user's events */
    case OnUserLoggedIn = 1 << 3;
    case OnUserProfileUpdated = 1 << 4;
    case OnUserAvatarUploaded = 1 << 5;
    /**
     * Returns an array of values to be used on <select> with <optgroups> and filtered options.
     *
     * @return array<int|string, array<int, string>|string>
     */
    public static function toSelectArray(): array
    {
        $questionEventsKey = (string) __('enums.actuators_related_with_question_events');
        $userEventsKey = (string) __('enums.actuators_related_with_user_events');

        return [
            self::None->value => self::None->description,
            $questionEventsKey => [
                self::OnQuestionAnswered->value => self::OnQuestionAnswered->description,
                self::OnQuestionCorrectlyAnswered->value => self::OnQuestionCorrectlyAnswered->description,
                self::OnQuestionIncorrectlyAnswered->value => self::OnQuestionIncorrectlyAnswered->description,
            ],
            $userEventsKey => [
                self::OnUserLoggedIn->value => self::OnUserLoggedIn->description,
                self::OnUserProfileUpdated->value => self::OnUserProfileUpdated->description,
                self::OnUserAvatarUploaded->value => self::OnUserAvatarUploaded->description,
            ],
        ];
    }
    public static function triggeredByQuestionsList(): string
    {
        return Arr::join(self::triggeredByQuestions(), ',');
    }
    public static function triggeredByQuestions(): array
    {
        return [
            self::OnQuestionAnswered->value,
            self::OnQuestionCorrectlyAnswered->value,
            self::OnQuestionIncorrectlyAnswered->value,
        ];
    }
    /**
     * Returns if the provided $actuator can be filtered by Tags.
     * Only Question based actuators can be filtered.
     */
    public static function canBeTagged(BadgeActuators $actuator): bool
    {
        return in_array($actuator, self::triggeredByQuestions());
    }
}
