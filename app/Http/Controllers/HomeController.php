<?php

namespace App\Http\Controllers;

use App\Models\Atributo;
use App\Models\Comprador;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\UbicacionFinca;
use App\Models\VariedadCafe;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class HomeController extends Controller
{
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

	    return view('products', compact('products', 'min_price', 'max_price', 'variedad_cafe', 'attributes', 'ubicaciones'));
    }

	/**
	 * Display or return a listing of the resources that matches with the user query.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function search(Request $request)
	{
		$query = e($request->keyword);

		if($request->ajax()) {
			if(!$query && $query == '')
				return response()->json([], 400);

			$products = Producto::estado()->nombre($query)->take(5)->with('fotos', 'proveedor')->get()->toArray();

			$providers = Proveedor::estado()->nombre($query)->take(5)->with('fotos')->get()->toArray();

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

	/**
	 * Append the given type on element position in data.
	 *
	 * @param $data
	 * @param $type
	 * @param $element
	 * @return mixed
	 */
	public function appendValue($data, $type, $element)
	{
		// operate on the item passed by reference, adding the element and type
		foreach ($data as $key => & $item) {
			$item[$element] = $type;
		}
		return $data;
	}

	/**
	 * Append the 'url' information in data.
	 *
	 * @param $data
	 * @param $prefix
	 * @return mixed
	 */
	public function appendURL($data, $prefix)
	{
		// operate on the item passed by reference, adding the url based on id
		foreach ($data as $key => & $item) {
			$item['url'] = route($prefix, $item[($item['class'] == 'product') ? 'idPublicacion' : 'id']);
		}
		return $data;
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
