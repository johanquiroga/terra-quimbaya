<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Carbon\Carbon;

class CreateReportRequest extends Request
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
        	//'type' => 'in:Preview,Submit',
	        'fechaInicio' => 'required|date|before:tomorrow',
	        'fechaCierre' => "required|date|before:tomorrow|after:$fechaInicio",
	        'tipoUsuario' => 'required|in:Proveedores,Compradores',
	        'usuarios' => 'required',
	        'usuarios.*' => "exists:$tabla"
        ];
    }
}
