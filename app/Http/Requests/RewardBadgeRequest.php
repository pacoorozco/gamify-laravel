<?php

namespace Gamify\Http\Requests;

use Illuminate\Validation\Rule;

class RewardBadgeRequest extends Request
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
            'badge_username' => ['required', 'string', Rule::exists('users', 'id')],
            'badge' => ['required', 'integer', Rule::exists('badges', 'id')],
        ];
    }
}
