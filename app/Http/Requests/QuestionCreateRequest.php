<?php

namespace Gamify\Http\Requests;

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
            'name' => ['required'],
            'question' => ['required'],
            //         'solution' => [''],
            'type' => ['required', 'in:single,multi'],
            'hidden' => ['required', 'boolean'],
            'status' => ['required', 'in:draft,publish,unpublish'],
            /*
            'tags' => ['nullable', 'array'],

            'choice_text' => ['required', 'array', 'min:2'],
            'choice_text.*' => ['required', 'string'],

            'choice_score' => ['required', 'array', 'min:2'],
            'choice_score.*' => ['required', 'integer'],*/
        ];
    }
}
