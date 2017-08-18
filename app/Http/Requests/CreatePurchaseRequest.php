<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Producto;

class CreatePurchaseRequest extends Request
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
	    $product = Producto::where('idPublicacion', $this->route('id'))->firstOrFail();
        return [
            'cantidad' => "required|greater_equal:1|less_equal:$product->cantidad",
	        'metodoPago' => "required|exists:metodoPago,id"
        ];
    }
}
