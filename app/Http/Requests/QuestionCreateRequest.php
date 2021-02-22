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

use Gamify\Models\Question;
use Illuminate\Validation\Rule;

class QuestionCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', Rule::unique('questions')],
            'question' => ['required', 'string'],
            'solution' => ['nullable', 'string'],
            'type' => ['required', Rule::in([
                Question::SINGLE_RESPONSE_TYPE,
                Question::MULTI_RESPONSE_TYPE,
            ])],
            'status' => ['required', Rule::in([
                'draft',
                'publish',
            ])],
            'hidden' => ['required', 'boolean'],
            'publication_date' => ['nullable', 'date_format:Y-m-d H:i'],

            // Tags
            'tags' => ['nullable', 'array'],
            'tags.*' => ['required', 'alpha_dash'],

            // Choices
            'choices.*.text' => ['required', 'string'],
            'choices.*.score' => ['required', 'integer'],
        ];
    }
}
