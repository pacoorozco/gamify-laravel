<?php

namespace Gamify\Http\Requests;

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
            'url'           => 'url',
            'date_of_birth' => 'date',
            'gender'        => 'required|in:male,female,unspecified',
            'twitter'       => 'url',
            'facebook'      => 'url',
            'googleplus'    => 'url',
            'linkedin'      => 'url',
            'github'        => 'url',
        ];
    }
}
