<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\DestroyAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Administrador;
use App\Models\Root;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Gate;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Yajra\Datatables\Datatables;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $board_user = Auth::user()->tipoUsuario;
        $type = 'admin';

        $admins = Administrador::estado()->get(['nombres', 'apellidos', 'id']);

        return view('gestion_usuarios.visualizar_usuario', compact('type','board_user', 'admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $board_user = Auth::user()->tipoUsuario;
        $type = 'admin';

        return view('gestion_usuarios.crear_usuario', compact('type','board_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAdminRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAdminRequest $request)
    {
        $request['contraseña'] = bcrypt($request['contraseña']);

	    $admin = Administrador::find($request->id);

	    if(is_null($admin)) {
		    $admin = Administrador::create($request->all());
	    } else {
		    if($admin->estado == 0) {
			    $admin->estado = 1;

			    $admin->fill($request->all());

			    $admin->save();
		    }
	    }

        Usuario::create([
            'idCC' => $admin->id,
            'email' => $admin->correoElectronico,
            'password' => $admin->contraseña,
            'tipoUsuario' => 'admin'
        ]);

        return Redirect::to('admins')
            ->with('message-success', 'Usuario creado satisfactoriamente');
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
        $data = Administrador::find($id);

        if(is_null($data)){
            return Redirect::route('admin::index');
        }

	    $this->authorize($data);

        $board_user = Auth::user()->tipoUsuario;
        $type = 'admin';

        return view('gestion_usuarios.editar_usuario', compact('type','board_user', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdminRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminRequest $request, $id)
    {
        $data = Administrador::findOrFail($id);

	    $this->authorize($data);

        if (empty($request['contraseña'])){
            $request['contraseña'] = $data['contraseña'];
        }
        else {
            $request['contraseña'] = bcrypt($request['contraseña']);
        }

	    if($data->estado == 1) {
		    $usuario = Usuario::where('email', '=', $data['correoElectronico'])->firstOrFail();
		    $usuario['idCC'] = $request['id'];
		    $usuario['email'] = $request['correoElectronico'];
		    $usuario['password'] = $request['contraseña'];
		    $usuario->save();

        	$data->fill($request->all());
		    $data->save();
	    } else {
		    $data->fill($request->all());

		    if($request->has('estado')) {
			    if (filter_var($request->estado, FILTER_VALIDATE_BOOLEAN)) {
				    $data->estado = 1;
			    } else {
				    $data->estado = 0;
			    }
		    }

		    $data->save();

		    if($data->estado == 1) {
		    	Usuario::create([
				    'idCC' => $data->id,
				    'email' => $data->correoElectronico,
				    'password' => $data->contraseña,
				    'tipoUsuario' => 'admin'
			    ]);
		    }
	    }

        return Redirect::to(route('admin::index'))
            ->with('message-success', 'Modificación realizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAdminRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyAdminRequest $request)
    {
	    $admin = Administrador::findOrFail($request->id);
	    $n_admin = Administrador::findOrFail($request->n_admin);
	    $usuario = Usuario::where('email', $admin->correoElectronico)->firstOrFail();

	    $this->authorize($admin);

	    $admin->estado = 0;

	    $proveedores = $admin->proveedores;

	    foreach ($proveedores as $proveedor) {
		    $proveedor->admin()->associate($n_admin)->save();
	    }

	    $productos = $admin->productos;

	    foreach ($productos as $producto) {
	    	$producto->admin()->associate($n_admin)->save();
	    }

	    $solicitudes = $admin->solicitudes()->where('estado', 'pendiente')->get();

	    foreach ($solicitudes as $solicitud) {
	    	$solicitud->admin()->associate($n_admin)->save();
	    }

	    $admin->save();

	    Usuario::destroy($usuario->id);

	    return redirect(route('admin::index'))->with('message-success', 'Administrador eliminado satisfactoriamente!');
    }

    public function anyData()
    {
    	$admins = Administrador::query();
    	if(Auth::user()->tipoUsuario == 'admin') {
    		$admins = $admins->estado();
	    }
        return Datatables::of($admins)->make(true);
    }
}
