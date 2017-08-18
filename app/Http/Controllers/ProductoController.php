<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuestionRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Administrador;
use App\Models\FotoProducto;
use App\Models\MetodoPago;
use App\Models\PreguntaProducto;
use App\Models\Producto;
use App\Http\Requests\CreateProductRequest;
use App\Models\Atributo;
use App\Models\Proveedor;
use App\Models\Solicitud;
use App\Models\TipoSolicitud;
use App\Models\VariedadCafe;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Pusher;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $board_user = Auth::user()->tipoUsuario;
        $type = 'product';

        return view('products.index', compact('type','board_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $board_user = Auth::user()->tipoUsuario;
        $type = 'product';

        $attributes = Atributo::all(['id', 'nombreAtributo', 'descripcionAtributo', 'opciones']);
        foreach ($attributes as $attribute) {
            if(!is_null($attribute->opciones))
                $attribute->opciones = explode(",", $attribute->opciones);
        }

        $providers = Proveedor::estado()->get(['id', 'nombres', 'apellidos']);
        $tipos_cafe = VariedadCafe::all();
        //dd($providers);

        return view('products.create', compact('type','board_user', 'attributes', 'providers', 'tipos_cafe'));
    }

	/**
	 * Generate a publication id of 10 random numeric characters.
	 *
	 * @return string
	 */
	private function generatePublicationId()
	{
		$faker = Faker::create();

		return $faker->regexify('^\d{10}$');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CreateProductRequest|Request $request
	 * @return \Illuminate\Http\Response
	 */
    public function store(CreateProductRequest $request)
    {
    	$product = Producto::firstOrNew([
    		'nombre' => $request->nombre,
    		'descripcion' => $request->descripcion,
    		'cantidad' => $request->cantidad,
		    'precioEmpaque' => $request->precioEmpaque
	    ]);

	    $idPublicacion = $this->generatePublicationId();
	    while(!Producto::where('idPublicacion', $idPublicacion)->get()->isEmpty()) {
		    $idPublicacion = $this->generatePublicationId();
	    }

	    $product->idPublicacion = $idPublicacion;

    	$coffee_types = VariedadCafe::find($request->idVariedadCafe);

    	$product->variedadCafe()->associate($coffee_types);

    	$provider = Proveedor::find($request->idProveedor);

    	$product->proveedor()->associate($provider);

    	$product->admin()->associate($provider->admin);

	    $attributes = Atributo::all(['id', 'nombreAtributo']);

	    $product->save();

	    foreach($attributes as $attribute) {
	    	$product->atributos()->attach($attribute->id, ['valorAtributo' => $request->input($attribute->nombreAtributo)]);
	    }

	    $this->savePhotos($product, $request->fotos);

	    return redirect(route('product::index'))->with('message-success', 'Producto creado satisfactoriamente!');
    }

    /**
     * Display the specified resource with all details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$product = Producto::where('idPublicacion', $id)->firstOrFail();

    	$product->load([
    	    'fotos',
            'atributos',
            'variedadCafe',
            'proveedor',
        ]);
    	$questions = $product->questions()->with('buyer')->paginate(5, ['*'], 'preguntas');
	    $reviews = $product->calificaciones()->with(['compra.comprador'])->paginate(5, ['*'], 'calificaciones');
    	$metodos_pago = MetodoPago::all();

        return view('products.show', compact('product', 'questions', 'metodos_pago', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $data = Producto::where('idPublicacion', $id)->firstOrFail();

	    if(is_null($data)) {
		    return redirect(route('product::index'));
	    }

	    $this->authorize($data);

	    $board_user = Auth::user()->tipoUsuario;
	    $type = 'product';

	    $attributes = Atributo::all(['id', 'nombreAtributo', 'descripcionAtributo', 'opciones']);
	    foreach ($attributes as $attribute) {
		    if(!is_null($attribute->opciones))
			    $attribute->opciones = explode(",", $attribute->opciones);
	    }

	    $providers = Proveedor::estado()->get(['id', 'nombres', 'apellidos']);
	    $tipos_cafe = VariedadCafe::all();

	    return view('products.edit', compact('type','board_user', 'data', 'attributes', 'providers', 'tipos_cafe'));
    }


	/**
	 * Update the specified resource in storage.
	 *
	 * @param UpdateProductRequest|Request $request
	 * @param  int  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function update(UpdateProductRequest $request, $id)
    {
	    $product = Producto::where('idPublicacion', $id)->firstOrFail();

	    $this->authorize($product);

	    $product->update([
		    'nombre' => $request->nombre,
		    'descripcion' => $request->descripcion,
		    'cantidad' => $request->cantidad,
		    'precioEmpaque' => $request->precioEmpaque,
	    ]);

	    if($request->has('estado')) {
		    if (filter_var($request->estado, FILTER_VALIDATE_BOOLEAN)) {
			    $product->estado = 1;
		    } else {
			    $product->estado = 0;
		    }
	    }

	    $coffee_types = VariedadCafe::find($request->idVariedadCafe);

	    $product->variedadCafe()->associate($coffee_types);

	    $attributes = Atributo::all(['id', 'nombreAtributo']);

	    $product->atributos()->sync($attributes);

	    foreach($attributes as $attribute) {
	    	$product->atributos()->updateExistingPivot($attribute->id, ['valorAtributo' => $request->input($attribute->nombreAtributo)]);
	    }

	    $product->save();

	    if(!(count($request->fotos) == 1 && is_null($request->fotos[0]))) {
		    $this->deletePhotos($product);
		    $this->savePhotos($product, $request->fotos);
	    }

	    return redirect(route('product::index'))->with('message-success', 'Modificación realizada con éxito');
    }

	/**
	 * Save the corresponding photos of the product.
	 *
	 * @param Producto $product
	 * @param array    $fotos
	 */
	private function savePhotos(Producto $product, array $fotos)
	{
		$path = 'img/products/'.$product->idPublicacion.'/';
		foreach ($fotos as $index => $foto) {
			if($foto->isValid()) {
				$file_name = $product->idPublicacion."_".str_replace([":","-"," "],["","_","_"], Carbon::now()->toDateTimeString()).'_'.$index.'.'.$foto->guessExtension();
				//dd($file_name);
				//$foto->move(public_path() . "/" . $path, $file_name);
				Storage::put("$path/$file_name", File::get($foto));
				$product->fotos()->save(
					new FotoProducto([
						'nombreArchivo' => $file_name,
						'path' => $path
					])
				);
			}
		}
	}

	/**
	 * Delete previously updated photos of the product.
	 *
	 * @param Producto $product
	 */
	private function deletePhotos(Producto $product)
	{
		if(!$product->fotos()->get()->isEmpty()) {
			$fotos = $product->fotos()->first();
			//File::cleanDirectory(public_path() . "/" . $fotos->path);
			$files = Storage::files($fotos->path);
			Storage::delete($files);

			$product->fotos()->delete();
		}
		//dd($fotos->path);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$product = Producto::where('idPublicacion', $request->id)->firstOrFail();

		$this->authorize($product);

		$product->estado = 0;

		$product->save();

		return redirect(route('product::index'))->with('message-success', 'Producto eliminado satisfactoriamente!');
	}

    /**
     * Return the query of Products
     *
     * @return mixed
     */
    public function anyData()
    {
	    $admin = Administrador::find(Auth::user()->idCC);
        $product = $admin->productos()->with( array(
            'variedadCafe' => function($query) {
                $query->select('id','tipo');
            },
            'atributos' => function($query) {
                $query->select('idAtributo', 'valorAtributo', 'nombreAtributo');
            },
            'admin' => function($query) {
                $query->select('id','nombres');
            },
            'proveedor' => function($query) {
                $query->select('id','nombres');
            }
        ));

        return DataTables::eloquent($product)->make(true);
    }

    /**
     * Post a question made by a Buyer
     *
     * @param CreateQuestionRequest|Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postQuestion(CreateQuestionRequest $request, $id)
    {
	    $product = Producto::estado()->where('idPublicacion', $id)->firstOrFail();

    	$question = PreguntaProducto::firstOrNew([
    		'consulta' => $request->consulta
	    ]);
    	$question->buyer()->associate(Auth::user()->idCC);
    	$question->product()->associate($product);
    	$question->save();

    	$solicitud = Solicitud::firstOrNew([
    		'mensaje' => $request->consulta,
            'leidoComprador' => true,
	    ]);
    	$tipo_solicitud = TipoSolicitud::where('tipo', 'pregunta')->get()->first();
    	$solicitud->tipoSolicitud()->associate($tipo_solicitud);
	    $solicitud->comprador()->associate(Auth::user()->idCC);

	    $solicitud->admin()->associate($product->admin);

	    $question->requests()->save($solicitud);

        $this->notifyQuestion($solicitud);

        return redirect(route('product::show',$id))->with('message-success', 'Pregunta publicada satisfactoriamente!');
    }

    /**
     * Trigger an event to notify to the Admin about new Question posted
     *
     * @param Solicitud $question
     */
    public function notifyQuestion(Solicitud $question)
    {
        $notification = array(
            'notificacion' => 'Han publicado una nueva pregunta en uno de tus productos.',
            'mensaje' => $question->mensaje,
            'tipo' => $question->tipoSolicitud->tipo,
            //'nombres' => $question->comprador->nombres,
            //'apellidos' => $question->comprador->apellidos,
            'href' => route('request::answer', $question->id),
        );
        $channel = 'notifications_' . $question->admin->id;

        $options = array(
            'cluster' => env("PUSHER_CLUSTER"),
            'encrypted' => true
        );
        $pusher = new Pusher(
            env("PUSHER_KEY"),
            env("PUSHER_SECRET"),
            env("PUSHER_APP_ID"),
            $options
        );
        $pusher->trigger($channel, 'notifications', $notification);
    }
}
