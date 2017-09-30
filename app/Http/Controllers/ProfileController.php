<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Atributo;
use App\Models\Comprador;
use App\Models\FrecuenciaCompraCafe;
use App\Models\NivelEstudios;
use App\Models\Root;
use App\Models\Usuario;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = Auth::user()->tipoUsuario;
        if($type == 'comprador') {
	        $nivelEstudios = NivelEstudios::all();
	        $frecuenciaCompraCafe = FrecuenciaCompraCafe::all();
	        $attributes = Atributo::all(['id', 'nombreAtributo', 'descripcionAtributo', 'opciones']);
            foreach ($attributes as $attribute) {
		        if(!is_null($attribute->opciones))
			        $attribute->opciones = explode(",", $attribute->opciones);
	        }
	        return view('layouts.profile', compact('type', 'nivelEstudios', 'frecuenciaCompraCafe', 'attributes'));
        } else {
	        return view('layouts.profile', compact('type'));
        }
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
     * @param Requests\UpdateProfileRequest|Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateProfileRequest $request, $id)
    {
        //dd($request->all());
        $usuario = Auth::user();
        $data = null;
        $buyer = false;
        switch ($usuario->tipoUsuario) {
            case 'root':
                $data = Root::findOrFail($id);
                break;
            case 'comprador':
                $buyer = true;
                $data = Comprador::findOrFail($id);
                break;
            case 'admin':
                $data = Administrador::findOrFail($id);
                break;
        }

        if (empty($request['contraseña'])){
            $request['contraseña'] = $data['contraseña'];
        }
        else {
            $request['contraseña'] = bcrypt($request['contraseña']);
        }

        $data->fill($request->all());
        $data->save();

        if($buyer) {
        	$frecuencia = FrecuenciaCompraCafe::find($request['idFrecuenciaCompraCafe']);
        	$data->frecuenciaCompraCafe()->associate($frecuencia);

	        $nivel = NivelEstudios::find($request['idNivelEstudios']);
	        $data->nivelEstudios()->associate($nivel);

            $data->direccion->fill($request->all())->save();
            $data->save();

	        $attributes = Atributo::all(['id', 'nombreAtributo']);

	        foreach($attributes as $attribute) {
		        $data->atributos()->updateExistingPivot($attribute->id, ['valorAtributo' => ($request->input($attribute->nombreAtributo) == "" ? null : $request->input($attribute->nombreAtributo))]);
	        }
        }

        $usuario['idCC'] = $request['id'];
        $usuario['email'] = $request['correoElectronico'];
        $usuario['password'] = $request['contraseña'];
        $usuario->save();

        return redirect(route('profile::profile'))->with('message-success', 'Perfil Actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    	if(Auth::user()->cannot('delete-account')) {
    		abort(403,'Forbidden action');
	    }

	    $usuario = Comprador::findOrFail($request->id);

	    //$usuario->nivelEstudios()->dissociate();

	    //$usuario->frecuenciaCompraCafe()->dissociate();

	    $usuario->atributos()->detach();

	    $usuario->estado = 0;

	    $usuario->save();

	    Usuario::destroy(Auth::user()->id);

	    Auth::logout();

	    return redirect('/')->with('message-success', 'Cuenta eliminada!');
    }
}
