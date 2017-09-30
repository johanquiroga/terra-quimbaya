<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CreateReportRequest extends FormRequest
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
    	$usuarios = \Request::input('tipoUsuario');
    	$inicio = \Request::input('fechaInicio');
	    $fechaInicio = Carbon::createFromFormat("Y-m-d", $inicio)->subDay()->toDateString();
    	if($usuarios == 'Proveedores') {
    		$tabla = "proveedor";
	    } else {
		    $tabla = "comprador";
	    }
        return [
	        'fechaInicio' => 'required|date|before:tomorrow',
	        'fechaCierre' => "required|date|before:tomorrow|after:$fechaInicio",
	        'tipoUsuario' => 'required|in:Proveedores,Compradores',
	        'usuarios' => 'required',
	        'usuarios.*' => "exists:$tabla,id"
        ];
    }
}
