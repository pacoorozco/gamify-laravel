<?php

namespace Gamify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'bio' => [
                'nullable',
                'string',
            ],
            'date_of_birth' => [
                'nullable',
                'date',
            ],
            'twitter' => [
                'nullable',
                'url',
            ],
            'facebook' => [
                'nullable',
                'url',
            ],
            'linkedin' => [
                'nullable',
                'url',
            ],
            'github' => [
                'nullable',
                'url',
            ],
            'avatar' => [
                'image',
            ],
        ];
    }
}
