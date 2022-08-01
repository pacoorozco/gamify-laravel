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
use Gamify\Presenters\BadgePresenter;

/**
 * @method static static OnQuestionAnswered()
 * @method static static OnQuestionCorrectlyAnswered()
 * @method static static OnQuestionIncorrectlyAnswered()
 * @method static static OnUserLogin()
 * @method static static None()
 */
final class BadgeActuators extends FlaggedEnum implements LocalizedEnum
{
    /** Actuators based on question's events */
    const OnQuestionAnswered = 1 << 0;

    const OnQuestionCorrectlyAnswered = 1 << 1;

    const OnQuestionIncorrectlyAnswered = 1 << 2;

    /** Actuators based on user's events */
    const OnUserLogin = 1 << 3;

    /**
     * Returns an array of values to be used on <select> with <optgroups> and filtered options.
     *
     * @return array
     *
     * @see BadgePresenter::actuatorsSelect()
     */
    public static function toSelectArray(): array
    {
        return BadgePresenter::actuatorsSelect();
    }

    /**
     * Returns if the provided $actuator can be filtered by Tags.
     * Only Question based actuators can be filtered.
     *
     * @param  string  $actuator
     * @return bool
     */
    public static function isTagsFiltered(string $actuator): bool
    {
        $actuator = self::coerce($actuator);

        return $actuator?->in([
            self::OnQuestionAnswered,
            self::OnQuestionCorrectlyAnswered,
            self::OnQuestionIncorrectlyAnswered,
        ]) ?? false;
    }
}
