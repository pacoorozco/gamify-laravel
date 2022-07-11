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

namespace Gamify\Http\Requests;

use Gamify\Models\User;
use Illuminate\Validation\Rule;

class RewardExperienceRequest extends Request
{
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                Rule::exists(User::class, 'username'),
            ],
            'points' => [
                'required',
                'integer',
            ],
            'message' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function usernameToReward(): string
    {
        return $this->input('username');
    }

    public function experience(): int
    {
        return $this->input('points');
    }

    public function reason(): ?string
    {
        return $this->input('message');
    }
}
