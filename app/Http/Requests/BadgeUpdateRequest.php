<?php

namespace Gamify\Http\Requests;

use Gamify\Badge;
use Illuminate\Validation\Rule;

class BadgeUpdateRequest extends Request
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
     * @param \Gamify\Badge $badge
     *
     * @return array
     */
    public function rules(Badge $badge)
    {
        return [
            'name'                 => ['required', 'string', Rule::unique('badges')->ignore($badge->id)],
            'description'          => ['required'],
            'required_repetitions' => ['required', 'integer', 'min:1'],
            'active'               => ['required', 'boolean'],
        ];
    }
}
