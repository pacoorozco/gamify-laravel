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

use Illuminate\Support\Arr;

enum BadgeActuators: int
{
    /** Actuators based on question's events */
    case None = 0;
    case OnQuestionAnswered = 1 << 0;
    case OnQuestionCorrectlyAnswered = 1 << 1;
    case OnQuestionIncorrectlyAnswered = 1 << 2;
    /** Actuators based on user's events */
    case OnUserLoggedIn = 1 << 3;
    case OnUserProfileUpdated = 1 << 4;
    case OnUserAvatarUploaded = 1 << 5;

    // Get a user-friendly label
    public function label(): string
    {
        return match ($this) {
            self::None => __('enums.badge_actuators.none'),
            self::OnQuestionAnswered => __('enums.badge_actuators.on_question_answered'),
            self::OnQuestionCorrectlyAnswered => __('enums.badge_actuators.on_question_correctly_answered'),
            self::OnQuestionIncorrectlyAnswered => __('enums.badge_actuators.on_question_incorrectly_answered'),
            self::OnUserLoggedIn => __('enums.badge_actuators.on_user_login'),
            self::OnUserProfileUpdated => __('enums.badge_actuators.on_user_profile_updated'),
            self::OnUserAvatarUploaded => __('enums.badge_actuators.on_user_avatar_uploaded'),
        };
    }

    // Static helper for forms
    public static function options(): array
    {
        $questionEventsKey = (string)__('enums.actuators_related_with_question_events');
        $userEventsKey = (string)__('enums.actuators_related_with_user_events');

        return [
            self::None->value => self::None->label(),
            $questionEventsKey => [
                self::OnQuestionAnswered->value => self::OnQuestionAnswered->label(),
                self::OnQuestionCorrectlyAnswered->value => self::OnQuestionCorrectlyAnswered->label(),
                self::OnQuestionIncorrectlyAnswered->value => self::OnQuestionIncorrectlyAnswered->label(),
            ],
            $userEventsKey => [
                self::OnUserLoggedIn->value => self::OnUserLoggedIn->label(),
                self::OnUserProfileUpdated->value => self::OnUserProfileUpdated->label(),
                self::OnUserAvatarUploaded->value => self::OnUserAvatarUploaded->label(),
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
