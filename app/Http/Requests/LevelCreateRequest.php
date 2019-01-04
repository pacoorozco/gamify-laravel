<?php

namespace Gamify\Http\Requests;

use Illuminate\Validation\Rule;

class LevelCreateRequest extends Request
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
            'name'            => ['required', 'string', Rule::unique('levels')],
            'required_points' => ['required', 'integer', 'min:1', Rule::unique('levels')],
            //'image'           => 'required|image',
            'active'          => ['required', 'boolean'],
        ];
    }
}
