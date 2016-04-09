<?php

namespace Gamify\Http\Requests;

class QuestionUpdateRequest extends Request
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
            'name'     => 'required',
            'question' => 'required',
            'solution' => '',
            'type'     => 'required|in:single,multi',
            'hidden'   => 'required|boolean',
            'status'   => 'required|in:draft,publish,unpublish',
        ];
    }
}
