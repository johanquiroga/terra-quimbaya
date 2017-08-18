<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
//use Illuminate\Routing\Route;

class UpdateAdminRequest extends Request
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
        //dd($this->route('id'));
        return [
//            ['id', 'nombres', 'apellidos', 'correoElectronico', 'contraseña', 'telefono', 'estado']
            'id' => ['required','unique:administrador,id,' . $this->route('id') . '','min:8','max:10','regex:/^(\d{8}|\d{10})$/'],
            'nombres' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'apellidos' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'correoElectronico' => 'required|email|max:45|unique:usuario,email,' . $this->route('id') . ',idCC|' .
                'unique:administrador,correoElectronico,'. $this->route('id'),
            'contraseña' => 'confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'telefono' => 'required|min:7|max:10|regex:/^\d{7,10}$/',
            'estado' => 'sometimes|required|in:0,1',
        ];
    }
}
