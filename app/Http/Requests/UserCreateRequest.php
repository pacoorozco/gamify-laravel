<?php

namespace Gamify\Http\Requests;

use Illuminate\Validation\Rule;

class UserCreateRequest extends Request
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
            'username' => ['required', 'string', Rule::unique('users')],
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email', Rule::unique('users')],
            'password' => ['required', 'string', 'between:4,11', 'confirmed'],
            'role'     => ['required', Rule::in(['user', 'editor', 'administrator'])],
        ];
    }
}
