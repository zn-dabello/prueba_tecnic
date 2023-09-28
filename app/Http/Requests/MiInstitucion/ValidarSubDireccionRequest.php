<?php

namespace App\Http\Requests\MiInstitucion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ValidarSubDireccionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $validacion = [
             'selectSubDireccion'=> 'numeric',
             'inputDescripcion' => 'required|min:1|max:600'
        ];

        return $validacion;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'inputDescripcion' => 'descripción',
             'selectSubDireccion'=> 'Subdirección',
        ];
    }
}
