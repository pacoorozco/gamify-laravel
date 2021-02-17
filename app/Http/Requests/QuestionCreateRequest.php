<?php

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
