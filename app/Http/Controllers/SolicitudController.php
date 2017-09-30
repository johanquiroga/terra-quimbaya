<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRequestRequest;
use App\Models\Administrador;
use App\Models\Comprador;
use App\Models\EstadoCompra;
use App\Models\Solicitud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Pusher\Pusher as Pusher;
use Yajra\Datatables\Facades\Datatables;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $board_user = Auth::user()->tipoUsuario;
        $type = 'request';

        return view('requests.index', compact('type', 'board_user'));
    }

    /**
     * Display a listing of the resource and mark as "read" the Current Request.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexBuyer($id)
    {
        $board_user = Auth::user()->tipoUsuario;

        /* Set to "read" */
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->leidoComprador = true;
        $solicitud->save();

        $type = 'request';

        return view('requests.index', compact('type', 'board_user'));
    }


    /**
     * Show the form for answering the specified request.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function answer($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        /* Set to "read" */
        $solicitud->leidoAdmin = true;
        $solicitud->save();

        $this->authorize('answer', $solicitud);

        $board_user = Auth::user()->tipoUsuario;
        $type = 'request';

        return view('requests.answer', compact('type', 'board_user', 'solicitud'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequestRequest|Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestRequest $request, $id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $this->authorize('update', $solicitud);

        $solicitud->respuesta = $request->respuesta;
        $solicitud->estado = $request->estado;
        $solicitud->leidoComprador = false;
        $solicitud->save();

        switch ($solicitud->tipoSolicitud->tipo) {
            case 'pregunta':
                $pregunta = $solicitud->requestable;
                $pregunta->respuesta = $solicitud->respuesta;
                $pregunta->save();
                $this->notifyAnswer($solicitud);
                break;
            case 'compra':
                $compra = $solicitud->requestable;
                if ($compra->estadoCompra->estado == 'pendiente' && $solicitud->estado == 'rechazada') {
                    $compra->product->cantidad = $compra->product->cantidad + $compra->cantidad;
                    $compra->product->save();
                }
                $compra->estadoCompra()->associate(EstadoCompra::where('estado', $solicitud->estado)->get()->first());
                $compra->save();
	            $this->notifyAnswer($solicitud);
                break;
            case 'devolucion':
            	$devolucion = $solicitud->requestable;

	            if ($devolucion->estado == 'pendiente') {

		            $devolucion->respuesta = $solicitud->respuesta;
		            $devolucion->estado = $solicitud->estado;
		            $devolucion->save();

	            	if($solicitud->estado == 'aceptada') {
			            $devolucion->compra->product->cantidad = $devolucion->compra->product->cantidad + $devolucion->compra->cantidad;
			            $devolucion->compra->product->save();

			            $devolucion->compra->calificacion()->delete();

			            $avg_calificacion = $devolucion->compra->product->calificaciones()->avg('calificacion');

			            $devolucion->compra->product->calificacion = $avg_calificacion;
			            $devolucion->compra->product->save();

			            $devolucion->compra->estadoCompra()->associate(EstadoCompra::where('estado',
				            'devuelto')->get()->first());
			            $devolucion->compra->save();
		            }
	            }

	            $this->notifyAnswer($solicitud);
                break;
        }
        return redirect(route('request::index'))->with('message-success', 'Respuesta registrada con éxito');
    }

    /**
     * Return the query of Requests
     *
     * @return mixed
     */
    public function anyData()
    {
        if (Auth::user()->tipoUsuario == 'admin') {
            $usuario = Administrador::find(Auth::user()->idCC);
        } else {
            $usuario = Comprador::find(Auth::user()->idCC);
        }

	    $requests = $usuario->solicitudes()->with([
	        'tipoSolicitud' => function ($query) {
	            $query->select('id', 'tipo');
	        },
	        'comprador' => function ($query) {
	            $query->with('direccion');
	            //->select('comprador.id','comprador.nombres', 'comprador.apellidos', 'comprador.telefono', 'direccion');
	        },
	        'admin',
	    ])->get();

        $requests = $requests->map(function ($solicitud) {
	        if($solicitud->requestable_type == 'App\Models\Devolucion') {
		        return $solicitud->load('requestable.compra', 'requestable.compra.product');
	        } else {
	        	return $solicitud->load('requestable.product');
	        }
        });

        return DataTables::of($requests)->make(true);
    }

    /**
     * Trigger a notification to the Buyer
     *
     * @param Solicitud $question
     */
    public function notifyAnswer(Solicitud $question)
    {
        $notification = array(
            'notificacion' => 'Han respondido a tu solicitud.',
            'mensaje' => $question->respuesta,
            'tipo' => 'Respuesta', /*$question->tipoSolicitud->tipo,*/
            //'nombres' => $question->comprador->nombres,
            //'apellidos' => $question->comprador->apellidos,
            'href' => route('request::indexBuyer',$question->id),
        );
        $channel = 'notifications_' . $question->comprador->id;

	    $options = config('broadcasting.connections.pusher.options');

	    $pusher = new Pusher(
		    config('broadcasting.connections.pusher.key'),
		    config('broadcasting.connections.pusher.secret'),
		    config('broadcasting.connections.pusher.app_id'),
		    $options
	    );
        $pusher->trigger($channel, 'notifications', $notification);
    }
}
