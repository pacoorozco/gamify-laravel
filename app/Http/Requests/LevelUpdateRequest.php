<?php

namespace Gamify\Http\Requests;

use Illuminate\Validation\Rule;

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
        $level = $this->route('level');

        // Rules for all Levels.
        $rules = [
            'name' => ['required', 'string', Rule::unique('levels')->ignore($level->id)],
            //'image'           => 'required|image',
        ];

        // Rules for non default Levels.
        if (! $level->isDefault()) {
            return array_merge(
                $rules,
                [
                    'required_points' => ['required', 'integer', 'min:1', Rule::unique('levels')->ignore($level->id)],
                    'active' => ['required', 'boolean'],
                ]
            );
        }

        return $rules;
    }
}
