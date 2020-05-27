<?php

namespace Gamify\Http\Requests;

use Gamify\User;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends Request
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
     * @param \Gamify\User $user
     *
     * @return array
     */
    public function rules(User $user)
    {
        return [
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'required_with:password_confirmation', 'string', 'min:5', 'confirmed'],
            'role' => ['required', Rule::in([
                User::USER_ROLE,
                User::EDITOR_ROLE,
                User::ADMIN_ROLE,
            ])],
        ];
    }
}
