<?php

namespace App\Http\Requests\MiInstitucion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class CambioClaveRequest extends FormRequest
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
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ];
    }
}
