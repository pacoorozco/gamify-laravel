<?php

namespace Gamify\Http\Requests;

class LevelUpdateRequest extends Request
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
        $level = $this->route('levels');

        return [
            'name'            => 'required|unique:levels,name,' . $level->id,
            'required_points' => 'required|integer|min:1',
            'image'           => 'image',
            'active'          => 'required|boolean',
        ];
    }
}
