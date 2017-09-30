<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Atributo;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
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
     * Get the validation rules that apply to the "root" user
     *
     * @return array
     */
    public function rootRules()
    {
        return [
            'id' => ['required','min:8','max:10','unique:root,id,'. $this->route('id') .'','regex:/^(\d{8}|\d{10})$/'],
            'nombres' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'apellidos' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'correoElectronico' => 'required|email|max:45|unique:usuario,email,' . $this->route('id') . ',idCC|' .
                'unique:root,correoElectronico,'. $this->route('id'),
            'contraseña' => 'nullable|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ];
    }

    /**
     * Get the validation rules that apply to the "admin" user
     *
     * @return array
     */
    public function adminRules()
    {
        return [
            'id' => ['required','min:8','max:10','unique:administrador,id,' . $this->route('id') . '','regex:/^(\d{8}|\d{10})$/'],
            'nombres' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'apellidos' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'correoElectronico' => 'required|email|max:45|unique:usuario,email,' . $this->route('id') . ',idCC|' .
                'unique:administrador,correoElectronico,'. $this->route('id'),
            'contraseña' => 'nullable|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'telefono' => 'required|min:7|max:10|regex:/^\d{7,10}$/'
        ];
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
			}
		}
		//dd($attrRules);
		return $attrRules;
	}

    /**
     * Get the validation rules that apply to the "comprador" user
     *
     * @return array
     */
    public function compradorRules()
    {
        $rules = [
            'id' => ['required','min:8','max:10','unique:comprador,id,'. $this->route('id') .'','regex:/^(\d{8}|\d{10})$/'],
            'nombres' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'apellidos' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'correoElectronico' => 'required|email|max:45|unique:usuario,email,' . $this->route('id') . ',idCC|' .
                'unique:comprador,correoElectronico,'. $this->route('id'),
            'contraseña' => 'nullable|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'telefono' => 'required|min:7|max:10|regex:/^\d{7,10}$/',
            'idFrecuenciaCompraCafe' => 'required|exists:frecuenciaCompraCafe,id',
            'idNivelEstudios' => 'required|exists:nivelEstudios,id',
            'direccion' => 'required|max:60',
            'direccionAuxiliar' => 'max:60',
            'codigoPostal' => 'required|max:10|regex:/^\d{0,10}$/',
            'ciudad' => 'required|max:45',
            'departamento' => 'required|max:45',
            'pais' => 'required|max:45'
        ];

	    return array_merge($rules, $this->atributos());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $role = Auth::user()->tipoUsuario;
        switch ($role) {
            case 'root':
                return $this->rootRules();
                break;
            case 'comprador':
                return $this->compradorRules();
                break;
            case 'admin':
                return $this->adminRules();
                break;
        }
    }
}
