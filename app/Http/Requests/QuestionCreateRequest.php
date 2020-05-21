<?php

namespace Gamify\Http\Requests;

use Gamify\Question;
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
            'name' => ['required', 'string'],
            'question' => ['required', 'string'],
            'explanation' => ['nullable', 'string'],
            'type' => ['required', Rule::in([
                Question::SINGLE_RESPONSE_TYPE,
                Question::MULTI_RESPONSE_TYPE,
            ])],
            'status' => ['required', Rule::in([
                Question::DRAFT_STATUS,
            ])],
            'hidden' => ['required', 'boolean'],
            'publication_date' => ['nullable', 'date'],

            // Tags
            'tags' => ['nullable', 'array'],
            'tags.*' => ['required', 'alpha_dash'],

            // Choices
            'choice_text' => ['required', 'array', 'min:2'],
            'choice_text.*' => ['required', 'string'],
            'choice_score' => ['required', 'array', 'min:2'],
            'choice_score.*' => ['required', 'integer'],
        ];
    }
}
