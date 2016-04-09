<?php

namespace Gamify\Http\Requests;

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
            'name'          => 'required|unique:levels,name',
            'amount_needed' => 'required|integer|min:1',
            'image'         => 'required|image',
            'active'        => 'required|boolean',
        ];
    }
}
