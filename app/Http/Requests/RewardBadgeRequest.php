<?php

namespace Gamify\Http\Requests;

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
//            'username' => 'required|exists:users,username',
//            'badge' => 'required|exists:badges,id'
        ];
    }
}
