<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateProviderRequest extends Request
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
            'id' => ['required','min:8','max:10','unique:proveedor,id,' . $this->route('id') . '','regex:/^(\d{8}|\d{10})$/'],
            'nombres' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'apellidos' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'nombreFinca' => 'required|max:45|regex:/^[a-zA-ZÀ-ž][\sa-zA-ZÀ-ž]*$/',
            'edadProveedor' => 'required|greater_equal:18|less_equal:150|regex:/^\d{1,3}$/',
            'telefono' => 'required|min:7|max:10|regex:/^\d{7,10}$/',
            'alturaFinca' => 'required|greater_equal:1000|less_equal:4000|regex:/^\d{4,4}$/',
            'extensionFinca' => 'required|numeric|digits_between:1,10',
            'extensionLotes' => 'required|numeric|digits_between:1,10',
            'idDensidadSiembra' => 'required|exists:densidadSiembra,id',
            'añosCafetal' => 'required|integer|greater_equal:1|less_equal:80',
            'idEdadUltimaZoca' => 'required|exists:edadUltimaZoca,id',
            'idTipoBeneficio' => 'required|exists:tipoBeneficio,id',
            'idEcotopo' => 'required|exists:ecotopo,id',
            'nucleoFamiliar' => 'required|integer|digits_between:1,2',
            'idNivelEstudios' => 'required|exists:nivelEstudios,id',
            'personasDependientesFinca' => 'required|integer|digits_between:1,3',
            'idVariedadCafe' => 'required',
            'idVariedadCafe.*' => 'exists:variedadCafe,id',
            'fotos' => 'required',
            'fotos.*' => 'image',
            'vereda' => 'required|max:45',
            'corregimiento' => 'required|max:45',
            'ciudad' => 'required|max:45',
            'departamento' => 'required|max:45',
            'pais' => 'required|in:COLOMBIA',
            'estado' => 'sometimes|required|in:0,1',
        ];
    }
}