<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateReviewRequest extends Request
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
            'calificacion' => 'required|numeric|greater_equal:0|less_equal:5',
	        'comentario' => 'string|max:800'
        ];
    }
}
