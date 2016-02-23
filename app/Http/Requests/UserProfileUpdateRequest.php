<?php

namespace Gamify\Http\Requests;

use Gamify\Http\Requests\Request;

class UserProfileUpdateRequest extends Request
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
            'url'      => 'url',
            'date_of_birth' => 'date',
            'gender'  => 'required|in:male,female,unspecified',
            'twitter'  => 'url',
            'facebook'  => 'url',
            'googleplus'  => 'url',
            'linkedin'  => 'url',
            'github'  => 'url',
        ];
    }
}
