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

use BenSampo\Enum\Rules\EnumValue;
use Gamify\Enums\BadgeActuators;
use Illuminate\Validation\Rule;

class BadgeUpdateRequest extends Request
{
    public function rules(): array
    {
        $badge = $this->route('badge');

        return [
            'name' => [
                'required',
                'string',
                Rule::unique('badges')->ignore($badge),
            ],
            'description' => [
                'required',
            ],
            'required_repetitions' => [
                'required',
                'integer',
                'min:1',
            ],
            'active' => [
                'required',
                'boolean',
            ],
            'actuators' => [
                'required',
                new EnumValue(BadgeActuators::class),
            ],

            // Tags
            'tags' => [
                'nullable',
                'array',
            ],
            'tags.*' => [
                'required',
                'alpha_dash',
            ],
        ];
    }

    public function name(): string
    {
        return $this->input('name');
    }

    public function description(): string
    {
        return $this->input('description');
    }

    public function repetitions(): int
    {
        return $this->input('required_repetitions');
    }

    public function active(): bool
    {
        return $this->input('active');
    }

    public function actuators(): string
    {
        return $this->input('actuators');
    }

    public function tags(): array
    {
        return $this->input('tags', []);
    }
}
