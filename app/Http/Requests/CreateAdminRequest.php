<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
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
            'id' => ['required','min:8','max:10','unique:administrador,id,NULL,id,estado,1','regex:/^(\d{8}|\d{10})$/'],
            'nombres' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'apellidos' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'correoElectronico' => 'required|email|max:45|unique:usuario,email|unique:comprador,correoElectronico,NULL,id,estado,1',
            'contraseña' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'telefono' => 'required|min:7|max:10|regex:/^\d{7,10}$/'
        ];
    }
}
