<?php

namespace Gamify\Http\Requests;

use BenSampo\Enum\Rules\EnumValue;
use Gamify\Enums\BadgeActuators;
use Illuminate\Validation\Rule;

class BadgeCreateRequest extends Request
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
            'name' => ['required', 'string', Rule::unique('badges')],
            'description' => ['required'],
            'required_repetitions' => ['required', 'integer', 'min:1'],
            'active' => ['required', 'boolean'],
            'actuators' => ['required', new EnumValue(BadgeActuators::class)],
        ];
    }
}
