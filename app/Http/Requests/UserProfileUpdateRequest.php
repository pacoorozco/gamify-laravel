<?php

namespace Gamify\Http\Requests;

use Illuminate\Validation\Rule;

class UserProfileUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->route('username');

        return $user->username == $this->user()->username;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => 'sometimes', 'url',
            'date_of_birth' => 'sometimes', 'date',
            'gender' => 'required', Rule::in(['male', 'female', 'unspecified']),
            'twitter' => 'sometimes', 'url',
            'facebook' => 'sometimes', 'url',
            'linkedin' => 'sometimes', 'url',
            'github' => 'sometimes', 'url',
        ];
    }
}
