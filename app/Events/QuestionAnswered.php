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

namespace Gamify\Events;

use Gamify\Models\Question;
use Gamify\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionAnswered
{
    use Dispatchable, SerializesModels;

    /** @var \Gamify\Models\User */
    public User $user;

    /** @var \Gamify\Models\Question */
    public Question $question;

    /** @var int */
    public int $points;

    /** @var bool */
    public bool $correctness;

    /**
     * Create a new event instance.
     *
     * @param  \Gamify\Models\User  $user
     * @param  \Gamify\Models\Question  $question
     * @param  int  $points
     * @param  bool  $correctness
     * @return void
     */
    public function __construct(User $user, Question $question, int $points, bool $correctness)
    {
        $this->user = $user;
        $this->question = $question;
        $this->points = $points;
        $this->correctness = $correctness;
    }
}
