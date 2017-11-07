<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProviderRequest;
use App\Http\Requests\DestroyProviderRequest;
use App\Http\Requests\UpdateProviderRequest;
use App\Miscelaneous;
use App\Models\Administrador;
use App\Models\DensidadSiembra;
use App\Models\Ecotopo;
use App\Models\EdadUltimaZoca;
use App\Models\FotoProveedor;
use App\Models\NivelEstudios;
use App\Models\Proveedor;
use App\Models\TipoBeneficio;
use App\Models\UbicacionFinca;
use App\Models\VariedadCafe;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Carbon\Carbon;
use Yajra\Datatables\Facades\Datatables;

class ProveedorController extends Controller
{
	use Miscelaneous;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $board_user = Auth::user()->tipoUsuario;
        $type = 'provider';

        return view('users.index', compact('type','board_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $board_user = Auth::user()->tipoUsuario;
        $type = 'provider';

        $densidadSiembra = DensidadSiembra::all();
        $edadUltimaZoca = EdadUltimaZoca::all();
        $tipoBeneficio = TipoBeneficio::all();
        $ecotopo = Ecotopo::all();
        $nivelEstudios = NivelEstudios::all();
	    $tipos_cafe = VariedadCafe::all();
	    $pais = 'COLOMBIA';

        return view('users.create', compact(
            'type','board_user', 'pais', 'densidadSiembra', 'edadUltimaZoca',
                'tipoBeneficio', 'ecotopo', 'nivelEstudios', 'tipos_cafe'));
    }

	/**
	 * Store a completely new provider.
	 *
	 * @param Request $request
	 * @return mixed
	 */
	private function storeNewProvider(Request $request)
    {
	    $provider = Proveedor::firstOrNew([
		    'id' => $request->id,
		    'nombres' => $request->nombres,
		    'apellidos' => $request->apellidos,
		    'edadProveedor' => $request->edadProveedor,
		    'telefono' => $request->telefono,
		    'nombreFinca' => $request->nombreFinca,
		    'alturaFinca' => $request->alturaFinca,
		    'extensionFinca' => $request->extensionFinca,
		    'extensionLotes' => $request->extensionLotes,
		    'añosCafetal' => $request->añosCafetal,
		    'nucleoFamiliar' => $request->nucleoFamiliar,
		    'personasDependientesFinca' => $request->personasDependientesFinca,
	    ]);

	    $ubicacion = new UbicacionFinca([
		    'vereda' => $request->vereda,
		    'corregimiento' => $request->corregimiento,
		    'ciudad' => $request->ciudad,
		    'departamento' => $request->departamento,
		    'pais' => $request->pais
	    ]);

	    $nivel = NivelEstudios::find($request->idNivelEstudios);
	    $provider->nivelEstudios()->associate($nivel);

	    $densidad = DensidadSiembra::find($request->idDensidadSiembra);
	    $provider->densidadSiembra()->associate($densidad);

	    $beneficio = TipoBeneficio::find($request->idTipoBeneficio);
	    $provider->tipoBeneficio()->associate($beneficio);

	    $zoca = EdadUltimaZoca::find($request->idEdadUltimaZoca);
	    $provider->edadUltimaZoca()->associate($zoca);

	    $ecotopos = Ecotopo::find($request->idEcotopo);
	    $provider->ecotopo()->associate($ecotopos);

	    $provider->admin()->associate(Auth::user()->idCC);

	    $provider->save();

	    $provider->ubicacionFinca()->save($ubicacion);

	    return $provider;
    }

	/**
	 * Update and reactivate a previously deleted provider.
	 *
	 * @param Proveedor $provider
	 * @param Request   $request
	 * @return Proveedor
	 */
	private function storeDeletedProvider(Proveedor $provider, Request $request)
    {
	    if($provider->estado == 0) {
		    $provider->estado = 1;

		    $provider->fill([
			    'id' => $request->id,
			    'nombres' => $request->nombres,
			    'apellidos' => $request->apellidos,
			    'edadProveedor' => $request->edadProveedor,
			    'telefono' => $request->telefono,
			    'nombreFinca' => $request->nombreFinca,
			    'alturaFinca' => $request->alturaFinca,
			    'extensionFinca' => $request->extensionFinca,
			    'extensionLotes' => $request->extensionLotes,
			    'añosCafetal' => $request->añosCafetal,
			    'nucleoFamiliar' => $request->nucleoFamiliar,
			    'personasDependientesFinca' => $request->personasDependientesFinca,
		    ]);

		    $provider->ubicacionFinca->fill([
			    'vereda' => $request->vereda,
			    'corregimiento' => $request->corregimiento,
			    'ciudad' => $request->ciudad,
			    'departamento' => $request->departamento,
			    'pais' => $request->pais
		    ])->save();
	    }

	    $nivel = NivelEstudios::find($request->idNivelEstudios);
	    $provider->nivelEstudios()->associate($nivel);

	    $densidad = DensidadSiembra::find($request->idDensidadSiembra);
	    $provider->densidadSiembra()->associate($densidad);

	    $beneficio = TipoBeneficio::find($request->idTipoBeneficio);
	    $provider->tipoBeneficio()->associate($beneficio);

	    $zoca = EdadUltimaZoca::find($request->idEdadUltimaZoca);
	    $provider->edadUltimaZoca()->associate($zoca);

	    $ecotopos = Ecotopo::find($request->idEcotopo);
	    $provider->ecotopo()->associate($ecotopos);

	    $provider->admin()->associate(Auth::user()->idCC);

	    $provider->save();

	    return $provider;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateProviderRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProviderRequest $request)
    {
    	$provider = Proveedor::find($request->id);

    	if(is_null($provider)) {
		    $provider = $this->storeNewProvider($request);
	    } else {
		    $provider = $this->storeDeletedProvider($provider, $request);
	    }

	    //foreach ($request->idVariedadCafe as $idVariedadCafe) {
		 //   $provider->variedadesCafe()->attach($idVariedadCafe);
	    //}
	    $provider->variedadesCafe()->sync($request->idVariedadCafe);

	    $this->deletePhotos($provider);
	    $this->savePhotos($provider, $request->fotos);

        return redirect(route('provider::index'))->with('message-success', 'Usuario creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $provider = Proveedor::findOrFail($id);
        $provider->load([
            'fotos',
	        //'productos' => function($query) {
        	//    $query->estado();
        	//    $query->with(['variedadCafe', 'fotos'])->paginate(2, ['*'], 'products');
	        //},
	        'variedadesCafe',
	        'densidadSiembra',
	        'edadUltimaZoca',
	        'tipoBeneficio',
	        'ecotopo',
        ]);

        $products = $provider->productos()->with(['fotos', 'variedadCafe'])->paginate(4, ['*'], 'products');

        //dd($provider);

	    if(!$request->expectsJson()) {
	    	return view('providers.show', compact('provider', 'products'));
	    } else {
		    $provider = $provider->toArray();
		    $provider = $this->cleanArray(array($provider), ['telefono', 'created_at', 'updated_at', 'estado',
			    'idDensidadSiembra', 'idEdadUltimaZoca', 'idTipoBeneficio', 'idEcotopo', 'nucleoFamiliar',
			    'idNivelEstudios', 'personasDependientesFinca', 'idAdministrador', 'densidad_siembra.id',
			    'edad_ultima_zoca.id', 'tipo_beneficio.id', 'ecotopo.id']);
		    $provider = $provider[0];

		    $products = $products->toArray();
		    $products["data"] = $this->cleanArray($products["data"], ['estado', 'created_at', 'updated_at', 'idVariedadCafe']);

		    $provider["productos"] = $products;
		    //$provider["productos"] = $this->cleanArray($provider["productos"], ['estado', 'created_at', 'updated_at', 'idVariedadCafe']);
		    $provider["fotos"] = $this->cleanArray($provider["fotos"], ['id']);
		    return response()->json(compact('provider'));
	    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Proveedor::find($id);

        //dd($data->variedadesCafe()->pluck('id')->toArray());

        if(is_null($data)){
            return redirect(route('provider::index'));
        }

	    $this->authorize('edit', $data);

        $board_user = Auth::user()->tipoUsuario;
        $type = 'provider';

        $densidadSiembra = DensidadSiembra::all();
        $edadUltimaZoca = EdadUltimaZoca::all();
        $tipoBeneficio = TipoBeneficio::all();
        $ecotopo = Ecotopo::all();
        $nivelEstudios = NivelEstudios::all();
	    $tipos_cafe = VariedadCafe::all();
	    $pais = 'COLOMBIA';

        return view('users.edit', compact(
            'type','board_user', 'data', 'densidadSiembra',
                'edadUltimaZoca','tipoBeneficio', 'ecotopo', 'nivelEstudios', 'tipos_cafe', 'pais'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProviderRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProviderRequest $request, $id)
    {
        $provider = Proveedor::findOrFail($id);

	    $this->authorize('update', $provider);

	    $provider->update([
            'id' => $request->id,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'edadProveedor' => $request->edadProveedor,
            'telefono' => $request->telefono,
            'nombreFinca' => $request->nombreFinca,
            'alturaFinca' => $request->alturaFinca,
            'extensionFinca' => $request->extensionFinca,
            'extensionLotes' => $request->extensionLotes,
            'añosCafetal' => $request->añosCafetal,
            'nucleoFamiliar' => $request->nucleoFamiliar,
            'personasDependientesFinca' => $request->personasDependientesFinca,
        ]);

	    if($request->has('estado')) {
		    if (filter_var($request->estado, FILTER_VALIDATE_BOOLEAN)) {
			    $provider->estado = 1;
		    } else {
			    $provider->estado = 0;
		    }
	    }

        $nivel = NivelEstudios::find($request->idNivelEstudios);
        $provider->nivelEstudios()->associate($nivel);

	    $provider->ubicacionFinca->fill($request->all())->save();

        $densidad = DensidadSiembra::find($request->idDensidadSiembra);
        $provider->densidadSiembra()->associate($densidad);

        $beneficio = TipoBeneficio::find($request->idTipoBeneficio);
        $provider->tipoBeneficio()->associate($beneficio);

        $zoca = EdadUltimaZoca::find($request->idEdadUltimaZoca);
        $provider->edadUltimaZoca()->associate($zoca);

        $ecotopos = Ecotopo::find($request->idEcotopo);
        $provider->ecotopo()->associate($ecotopos);

        $provider->admin()->associate(Auth::user()->idCC);

        $provider->save();

        $provider->variedadesCafe()->sync($request->idVariedadCafe);

	    if($request->hasFile('fotos')) {
	    	if(!(count($request->fotos) == 1 && is_null($request->fotos[0]))) {
			    $this->deletePhotos($provider);
			    $this->savePhotos($provider, $request->fotos);
		    }
	    }

        return redirect(route('provider::index'))
            ->with('message-success', 'Modificación realizada con éxito');
    }

	/**
	 * Save the corresponding photos of the provider.
	 *
	 * @param Proveedor $provider
	 * @param array     $fotos
	 */
	private function savePhotos(Proveedor $provider, array $fotos)
	{
		$path = 'providers/'.$provider->id;
		foreach ($fotos as $index => $foto) {
			if($foto->isValid()) {
				$file_name = $provider->id."_".str_replace([":","-"," "],["","_","_"], Carbon::now()->toDateTimeString()).'_'.$index.'.'.$foto->guessExtension();
				//dd($file_name);
				//$foto->move(public_path() . "/" . $path, $file_name);
				Storage::put("$path/$file_name", File::get($foto), 'public');
				$provider->fotos()->save(
					new FotoProveedor([
						'nombreArchivo' => $file_name,
						'path' => $path
					])
				);
			}
		}
	}

	/**
	 * Delete previously updated photos of the provider.
	 *
	 * @param Proveedor $provider
	 */
	private function deletePhotos(Proveedor $provider)
    {
    	if(!$provider->fotos()->get()->isEmpty()) {
		    $fotos = $provider->fotos()->first();
		    //File::cleanDirectory(public_path() . "/" . $fotos->path);
		    $files = Storage::files($fotos->path);
		    Storage::delete($files);

		    $provider->fotos()->delete();
	    }
    	//dd($fotos->path);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param DestroyProviderRequest|Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(DestroyProviderRequest $request)
	{
		$provider = Proveedor::findOrFail($request->id);

		$this->authorize('destroy', $provider);

		$provider->estado = 0;

		$productos = $provider->productos;

		foreach ($productos as $producto) {
			$producto->estado = 0;
			$producto->save();
		}

		$provider->save();

		return redirect(route('provider::index'))->with('message-success', 'Proveedor eliminado satisfactoriamente!');
	}

    /**
     * Return the query of users Providers
     *
     * @return mixed
     */
    public function anyData()
    {
	    $admin = Administrador::find(Auth::user()->idCC);
        $provider = $admin->proveedores()->with( array(
            'nivelEstudios' => function ($query) {
                $query->select('id', 'tipo');
            },
            'ubicacionFinca' => function($query) {
                $query->select('idProveedor', 'pais', 'departamento',
                    'ciudad', 'corregimiento', 'vereda');
            },
            'densidadSiembra' => function($query) {
                $query->select('id', 'tipo');
            },
            'tipoBeneficio' => function($query) {
                $query->select('id', 'tipo');
            },
            'edadUltimaZoca' => function($query) {
                $query->select('id', 'tipo');
            },
            'ecotopo' => function($query) {
                $query->select('id', 'tipo');
            },
            'variedadesCafe' => function($query) {
                $query->select('idVariedadCafe', 'tipo');
            },
        ));
        return Datatables::eloquent($provider)->make(true);
    }
}
