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

namespace Gamify\Listeners;

use Gamify\Enums\BadgeActuators;
use Gamify\Events\QuestionAnswered;
use Gamify\Libs\Game\Game;
use Gamify\Models\Badge;
use Gamify\Models\User;

/**
 * Trigger Badges with an actuator related to Questions (OnQuestion[*]) and the mathcing tags.
 */
class IncrementBadgesOnQuestionAnswered
{
    public function handle(QuestionAnswered $event): void
    {
        /** @var User $user */
        $user = User::findOrFail($event->user->getAuthIdentifier());

        $badges = Badge::whereIn('actuators', [
            BadgeActuators::OnQuestionAnswered,
            ($event->correctness === true)
                ? BadgeActuators::OnQuestionCorrectlyAnswered
                : BadgeActuators::OnQuestionIncorrectlyAnswered,
        ])
            ->when($event->question->tagArray, function ($query) use ($event) {
                $query->withAnyTags($event->question->tagArray);
            }, function ($query) {
                $query->isNotTagged();
            })
            ->get();

        Game::incrementManyBadgesCount($user, $badges);
    }
}
