<?php

namespace Gamify\Http\Requests;

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
     * @return array
     */
    public function rules()
    {
        $badge = $this->route('badge');

        return [
            'name'                 => ['required', 'string', Rule::unique('badges')->ignore($badge->id)],
            'description'          => ['required'],
            'required_repetitions' => ['required', 'integer', 'min:1'],
            'active'               => ['required', 'boolean'],
        ];
    }
}
