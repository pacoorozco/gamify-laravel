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
        $rules = [
            'name'     => 'required',
            'question' => 'required',
            'solution' => '',
            'type'     => 'required|in:single,multi',
            'hidden'   => 'required|boolean',
            'status'   => 'required|in:draft,publish,unpublish'
        ];

        // TODO: validate dynamic choices
//        foreach ($this->request->get('choice_text') as $key => $val) {
//            if (!empty($val)) {
//                $rules['choice_text.' . $key] = 'required';
//                $rules['choice_points.' . $key] = 'required|integer';
//            }
//        }

        return $rules;
    }
}
