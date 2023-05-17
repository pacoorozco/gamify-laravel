<?php

namespace Gamify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current-password' => [
                'required',
                'current_password',
            ],
            'new-password' => [
                'required',
                Password::defaults(),
                'confirmed',
            ],
        ];
    }

    public function newPassword(): string
    {
        return $this->input('new-password');
    }
}
