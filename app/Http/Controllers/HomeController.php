<?php

namespace App\Http\Controllers;

use App\Miscelaneous;
use App\Models\Atributo;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\UbicacionFinca;
use App\Models\VariedadCafe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	use Miscelaneous;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$min_price = Producto::estado()->min('precioEmpaque');
		$max_price = Producto::estado()->max('precioEmpaque');

		$variedad_cafe = VariedadCafe::all();

		$ubicaciones = UbicacionFinca::all()->unique('departamento');

		$attributes = Atributo::all(['id', 'nombreAtributo', 'descripcionAtributo', 'opciones']);
		foreach ($attributes as $attribute) {
			if(!is_null($attribute->opciones))
				$attribute->opciones = explode(",", $attribute->opciones);
		}

		$products = Producto::estado();

		$queries = [];
		if(!empty($request->all())) {

			if($request->has('variedadCafe')) {
				$queries['variedadCafe'] = $request->variedadCafe;
				$products->variedad($request->variedadCafe);
			}

			foreach ($attributes as $attribute) {
				if($request->has($attribute->nombreAtributo)) {
					$queries[$attribute->nombreAtributo] = $request->input($attribute->nombreAtributo);
					$products = $products->tieneAtributos($attribute->nombreAtributo, $request->input($attribute->nombreAtributo));
				}
			}

			if($request->has('ubicacionFinca')) {
				$queries['ubicacionFinca'] = $request->ubicacionFinca;
				$products->ubicacion($request->ubicacionFinca);
			}

			$products = $products->precio($request['price-left'], $request['price-right']);
			$queries['price-left'] = $request['price-left'];
			$queries['price-right'] = $request['price-right'];
		} /*else if(Auth::check()) {
		    $user = Auth::user();
    		if($user->tipoUsuario == 'comprador') {
    			$comprador = Comprador::find($user->idCC);
    			$atributos = $comprador->atributos;

			    foreach ($atributos as $atributo) {
			    	$queries[$atributo->nombreAtributo] = $atributo->pivot->valorAtributo;
			    	if(!is_null($atributo->opciones)) {
					    $products = $products->tieneAtributos($atributo->nombreAtributo,
						    [ $atributo->pivot->valorAtributo ], 'or');
				    }
			    }
		    }
	    }*/

		$products = $products->with('fotos', 'variedadCafe')->paginate(15, ['*'], 'page')->appends($queries);

		if(!$request->expectsJson()) {
			return view('store',
				compact('products', 'min_price', 'max_price', 'variedad_cafe', 'attributes', 'ubicaciones'));
		} else {
			$products = $products->toArray();
			$products["data"] = $this->cleanArray($products["data"], ['idVariedadCafe', 'variedad_cafe.id', 'cantidad', 'estado', 'created_at', 'updated_at']);
			return response()->json(compact('products', 'min_price', 'max_price', 'variedad_cafe', 'attributes', 'ubicaciones'));
		}
	}

	/**
	 * Display or return a listing of the resources that matches with the user query.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function search(Request $request)
	{
		$query = e($request->keyword);

		if($request->ajax() || $request->expectsJson()) {
			if(!$query && $query == '')
				return response()->json([], 400);

			$products = Producto::estado()->nombre($query)->take(5)->with('fotos', 'proveedor')->get()->toArray();
			$products = $this->cleanArray($products, ['proveedor.telefono', 'proveedor.idAdministrador', 'idVariedadCafe', 'descripcion', 'cantidad', 'precioEmpaque', 'calificacion', 'estado', 'created_at', 'updated_at', 'proveedor.estado', 'proveedor.created_at', 'proveedor.updated_at', 'proveedor.nombreFinca', 'proveedor.edadProveedor', 'proveedor.alturaFinca', 'proveedor.extensionFinca', 'proveedor.extensionLotes', 'proveedor.idDensidadSiembra', 'proveedor.añosCafetal', 'proveedor.idEdadUltimaZoca', 'proveedor.idTipoBeneficio', 'proveedor.idEcotopo', 'proveedor.nucleoFamiliar', 'proveedor.idNivelEstudios', 'proveedor.personasDependientesFinca']);

			$providers = Proveedor::estado()->nombre($query)->take(5)->with('fotos')->get()->toArray();
			$providers = $this->cleanArray($providers, ['telefono', 'idAdministrador', 'estado', 'created_at', 'updated_at','edadProveedor', 'alturaFinca', 'extensionFinca', 'extensionLotes', 'idDensidadSiembra', 'añosCafetal', 'idEdadUltimaZoca', 'idTipoBeneficio', 'idEcotopo', 'nucleoFamiliar', 'idNivelEstudios', 'personasDependientesFinca']);

			$products = $this->appendValue($products, 'product', 'class');
			$providers = $this->appendValue($providers, 'provider', 'class');

			$products = $this->appendURL($products, 'product::show');
			$providers = $this->appendURL($providers, 'provider::show');

			$data = array_merge($products, $providers);

			return response()->json(['data' => $data]);
		} else {
			$min_price = Producto::estado()->min('precioEmpaque');
			$max_price = Producto::estado()->max('precioEmpaque');

			$variedad_cafe = VariedadCafe::all();

			$ubicaciones = UbicacionFinca::all();

			$attributes = Atributo::all(['id', 'nombreAtributo', 'descripcionAtributo', 'opciones']);
			foreach ($attributes as $attribute) {
				if(!is_null($attribute->opciones))
					$attribute->opciones = explode(",", $attribute->opciones);
			}

			$products = Producto::estado();
			$queries = [];
			if(trim($query) != '') {
				$queries['keyword'] = $request->keyword;
				$products = $products->nombre($query);
			}
			$products = $products->with('fotos', 'variedadCafe')->paginate(15, ['*'])->appends($queries);
			return view('products', compact('products', 'min_price', 'max_price', 'variedad_cafe', 'attributes', 'ubicaciones'));
		}

	}
}
