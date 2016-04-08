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
        $rules = [
            'name' => 'required',
            'question' => 'required',
            'solution' => '',
            'type' => 'required|in:single,multi',
            'hidden' => 'required|boolean',
            'status' => 'required|in:draft,publish,unpublish'
        ];

        // validate dynamic choices
        foreach ($this->request->get('text') as $key => $val) {
            if (!empty($val)) {
                $rules['text.' . $key] = 'required';
                $rules['points.' . $key] = 'required|integer';
            }
        }

        return $rules;
    }
}
