<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Atributo;
use Illuminate\Support\Facades\Request;

class CreateProductRequest extends FormRequest
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
     * Get the validation rules for the different attributes of a product
     *
     */
    private function atributos()
    {
        $attrRules = array();
        $attributes = Atributo::all(['id', 'nombreAtributo', 'opciones']);
        foreach ($attributes as $attribute) {
            $attrRules[$attribute->nombreAtributo] = 'nullable';
            if(!is_null($attribute->opciones)) {
                $attrRules[$attribute->nombreAtributo] = $attrRules[$attribute->nombreAtributo] . '|in:' . $attribute->opciones;
            } else {
	            $attrRules[$attribute->nombreAtributo] = $attrRules[$attribute->nombreAtributo] .'|max:255';
            }
        }
        //dd($attrRules);
        return $attrRules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'idProveedor' => 'required|exists:proveedor,id',
            'idVariedadCafe' => 'required|exists:variedadCafe,id',
	        'nombre' => 'required|unique:producto,nombre,NULL,id,idProveedor,'. Request::input('idProveedor'),
	        'descripcion' => 'required|max:255',
            'cantidad' => 'required|integer|min:0',
            'precioEmpaque' => 'required|numeric|min:0',
            'fotos' => 'required',
            'fotos.*' => 'image'
        ];
        return array_merge($rules, $this->atributos());
    }
}
