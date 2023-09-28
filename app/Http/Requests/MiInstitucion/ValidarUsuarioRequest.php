<?php

namespace App\Http\Requests\MiInstitucion;

use Illuminate\Foundation\Http\FormRequest;

class ValidarUsuarioRequest extends FormRequest
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
            'inputCorreo' => 'required|email|min:1|max:600',
            'inputNombre' => 'required|min:1|max:600',
            'inputApellido' => 'required|min:1|max:600',
            'selectEncargado' => 'required|numeric',
            'selectDireccion' => 'nullable|numeric',
            'selectUnidad' => 'nullable|numeric',
            'selectSubUnidad' => 'nullable|numeric',
            'inputRut' => 'numeric',
            'inputTelefono'=> 'nullable|digits_between:7,8',
            'digito' => 'digits_between:1,2',
            'inputCargo' => 'max:600'
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
            'inputCorreo' => 'correo electrónico',
            'inputNombre' => 'nombre',
            'inputApellido' => 'apellido',
            'selectEncargado' => 'encargado de',
            'selectDireccion' => 'dirección',
            'selectUnidad' => 'unida',
            'selectSubUnidad' => 'sub-dirección',
            'inputRut' => 'rut',
            'inputTelefono'=> 'teléfono',
            'digito' => 'dígito',
            'inputCargo' => 'cargo'
        ];
    }
}
