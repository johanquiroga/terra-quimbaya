<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePurchaseRequest;
use App\Http\Requests\CreateRefundRequest;
use App\Http\Requests\CreateReviewRequest;
use App\Models\CalificacionProducto;
use App\Models\Compra;
use App\Models\Comprador;
use App\Models\Devolucion;
use App\Models\EstadoCompra;
use App\Models\MetodoPago;
use App\Models\Producto;
use App\Models\Solicitud;
use App\Models\TipoSolicitud;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Log;
use Pusher;
use Faker\Factory as Faker;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

	/**
	 * Process the request to buy a product.
	 *
	 * @param CreatePurchaseRequest|Request $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function buy(CreatePurchaseRequest $request, $id)
	{
		//$cantidad = $request->cantidad;
		$metodo_pago = MetodoPago::findOrFail($request->metodoPago);
		$product = Producto::estado()->where('idPublicacion', $id)->firstOrFail();
		if($product->cantidad == 0) {
			return redirect('/')->with('message-error', 'Lo sentimos, parece que estas intentando comprar un producto que no tenemos disponible.');
		}
		$usuario = Comprador::findOrFail($request->user()->idCC);
		$usuario->load('direccion');

		if($metodo_pago->metodo == 'Contraentrega') {
			return $this->buyContraEntrega($request, $product, $usuario, $metodo_pago);
		} else {
			return $this->buyExterno($request, $product, $usuario, $metodo_pago);
		}
	}

    /**
     * Store a newly created review resource in storage.
     *
     * @param CreateReviewRequest|Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function review(CreateReviewRequest $request, $id)
    {
	    $compra = Compra::where('idOrden', $id)->firstOrFail();
	    $this->authorize($compra);

	    $calificacion = new CalificacionProducto([
	    	'calificacion' => floatval($request->calificacion),
		    'comentario' => $request->comentario
	    ]);

	    $compra->calificacion()->save($calificacion);

	    $avg_calificacion = $compra->product->calificaciones()->avg('calificacion');

	    $product = $compra->product;
	    $product->calificacion = $avg_calificacion;
	    $product->save();

	    return redirect(route('purchase::show', $compra->idOrden))->with('message-success', 'Calificación guardada exitosamente!');
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function editReview($id)
	{
		$compra = Compra::where('idOrden', $id)->firstOrFail();
		$this->authorize($compra);

		$board_user = Auth::user()->tipoUsuario;
		$type = 'request';

		$compra->load('calificacion');

		return view('purchases.reviews.edit', compact('board_user', 'type', 'compra'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param CreateReviewRequest|Request $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateReview(CreateReviewRequest $request, $id)
	{
		$compra = Compra::where('idOrden', $id)->firstOrFail();
		$this->authorize($compra);

		$calificacion = $compra->calificacion;
		$calificacion->calificacion = floatval($request->calificacion);
		$calificacion->comentario = $request->comentario;

		$calificacion->save();

		$avg_calificacion = $compra->product->calificaciones()->avg('calificacion');

		$product = $compra->product;
		$product->calificacion = $avg_calificacion;
		$product->save();

		return redirect(route('purchase::show', $compra->idOrden))->with('message-success', 'Calificación actualizada exitosamente!');
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $compra = Compra::where('idOrden', $id)->firstOrFail();
        $compra->load([
        	'product' => function($query) {
        	    $query->with([
        	    	'fotos',
		            'admin',
		            'proveedor' => function($query) {
        	    	    $query->with(['ubicacionFinca', 'fotos']);
        	        }
                ]);
            },
	        'estadoCompra',
	        'comprador' => function($query) {
		        $query->with('direccion');
	        },
	        'metodoPago',
	        'calificacion',
        ]);

        $this->authorize($compra);

	    $board_user = Auth::user()->tipoUsuario;
	    $type = 'request';

        return view('purchases.show', compact('board_user', 'type', 'compra'));
    }


	public function refund($id)
	{
		$compra = Compra::where('idOrden', $id)->firstOrFail()->load('estadoCompra');
		$this->authorize($compra);

		$board_user = Auth::user()->tipoUsuario;
		$type = 'request';

		return view('purchases.refund',  compact('board_user', 'type', 'compra'));
    }

	public function sendRefund(CreateRefundRequest $request, $id)
	{
		$compra = Compra::where('idOrden', $id)->firstOrFail()->load('estadoCompra');
		$this->authorize($compra);

		$devolucion = new Devolucion([
			'mensaje' => $request->mensaje,
		]);

		$compra->devoluciones()->save($devolucion);

		$solicitud = new Solicitud([
			'mensaje' => $devolucion->mensaje,
			'leidoComprador' => true,
		]);

		$tipo_solicitud = TipoSolicitud::where('tipo', 'devolucion')->get()->first();
		$solicitud->tipoSolicitud()->associate($tipo_solicitud);
		$solicitud->comprador()->associate($compra->comprador);
		$solicitud->admin()->associate($compra->product->admin);

		$devolucion->requests()->save($solicitud);

		$this->notifyRefund($solicitud, $compra);

		return redirect(route('purchase::show', $id))->with('message-success', 'Solicitud de devolución enviada satisfactoriamente!');
	}

	/**
	 * Display the result of the purchase.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function response(Request $request, $id)
	{
		$board_user = Auth::user()->tipoUsuario;
		$type = 'request';

		$compra = Compra::where('idOrden', $id)->firstOrFail();
		$compra->load([
			'estadoCompra',
			'metodoPago'
		]);

		$this->authorize($compra);

		$estadoTx = null;
		$TX_VALUE = null;
		$transactionId = null;
		$currency = null;

		if(!empty($request->all())) {
			//$data = $request->all();
			$ApiKey = env("PAYU_KEY", '4Vj8eK4rloUd272L48hsrarnUA');
			$merchant_id = $request->merchantId;
			$referenceCode = $request->referenceCode;
			$reference_pol = $request->reference_pol;
			$TX_VALUE = $request->TX_VALUE;
			$New_value = number_format($TX_VALUE, 1, '.', '');
			$currency = $request->currency;
			$transactionState = $request->transactionState;
			$firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
			$firmacreada = sha1($firma_cadena);
			$firma = $request->signature;
			$transactionId = $request->transactionId;
			$processingDate = $request->processingDate;

			if ($transactionState == 4 ) {
				$estadoTx = "Transacción aprobada";
				//$compra->estadoCompra()->associate(EstadoCompra::where('estado', 'aceptada')->get()->first());
			}

			else if ($transactionState == 6 ) {
				$estadoTx = "Transacción rechazada";
				//$compra->estadoCompra()->associate(EstadoCompra::where('estado', 'rechazada')->get()->first());
			}

			else if ($transactionState == 104 ) {
				$estadoTx = "Error";
			}

			else if ($transactionState == 7 ) {
				$estadoTx = "Transacción pendiente";
				//$compra->estadoCompra()->associate(EstadoCompra::where('estado', 'pendiente')->get()->first());
			}

			else {
				$estadoTx = $request->message;
			}

			if (strtoupper($firma) != strtoupper($firmacreada)) {
				return view('purchases.response', compact('board_user', 'type'));
			}
			//dd($data);
		}

		return view('purchases.response', compact('board_user', 'type', 'compra', 'TX_VALUE', 'estadoTx', 'currency', 'transactionId', 'processingDate', 'reference_pol'));
	}

	/**
	 * Update the specified resource in storage for external payments.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function confirmation(Request $request, $id)
	{
        log::info('New post request to ' . $id. ' with state_pol '.$request->state_pol);
		$compra = Compra::where('idOrden', $id)->firstOrFail();

		$ApiKey = env("PAYU_KEY", '4Vj8eK4rloUd272L48hsrarnUA');
		$merchant_id = $request->merchant_id;
		$reference_sale = $request->reference_sale;
		$reference_pol = $request->reference_pol;
		$value = $request->value;
		$new_value = number_format($value, 2, '.', '');
		$new_value = ($new_value[-1] == 0) ? substr($new_value, 0, -1) : $new_value;
		$currency = $request->currency;
		$state_pol = $request->state_pol;
		$firma_cadena = "$ApiKey~$merchant_id~$reference_sale~$new_value~$currency~$state_pol";
		$firmacreada = sha1($firma_cadena);
		$firma = $request->sign;
		//$transaction_id = $request->transaction_id;
		$transaction_date = $request->transaction_date;

		if ($state_pol == 4 ) {
			$estadoTx = "Transacción aprobada";
			$compra->estadoCompra()->associate(EstadoCompra::where('estado', 'aceptada')->get()->first());
		} else if ($state_pol == 6 ) {
			$estadoTx = "Transacción rechazada";
			$compra->estadoCompra()->associate(EstadoCompra::where('estado', 'rechazada')->get()->first());
		} else if ($state_pol == 5 ) {
			$estadoTx = "Transacción expirada";
			$compra->estadoCompra()->associate(EstadoCompra::where('estado', 'rechazada')->get()->first());
		} else {
			$estadoTx = $request->response_message_pol;
		}

		$respuesta = '';

		if (strtoupper($firma) != strtoupper($firmacreada)) {
			$compra->estadoCompra()->associate(EstadoCompra::where('estado', 'pendiente')->get()->first());
			$respuesta = 'No se pudo verificar consistencia en los datos recibidos por el sistema de pagos externos, se descarta la transacción';
		} else {
			$respuesta = "$estadoTx en el pago con referencia $reference_pol por el valor de $value el $transaction_date.";
		}

		$compra->save();
		if($compra->estadoCompra->estado == 'rechazada') {
			$compra->product->cantidad = $compra->product->cantidad + $compra->cantidad;
			$compra->product->save();
		}

		$solicitud = $compra->requests;
		$solicitud->respuesta = $respuesta;
		$solicitud->estado = $compra->estadoCompra->estado;
		$solicitud->leidoComprador = false;
		$solicitud->save();

        Log::info('Confirmation created: '.$compra->id.' With state: '.$compra->estadoCompra->estado);

		$this->notifyPurchase($solicitud, $compra->product);
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

	/**
	 * Process the purchase request with payment method "Contra entrega"
	 *
	 * @param Request    $request
	 * @param Producto   $product
	 * @param Comprador  $comprador
	 * @param MetodoPago $metodoPago
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function buyContraEntrega(Request $request, Producto $product, Comprador $comprador, MetodoPago $metodoPago)
	{
		$cantidad = $request->cantidad;
		$amount = $product->precioEmpaque * $cantidad;
		$tax = $amount*0.19;
		$valorTotal = $amount + $tax;
		$description = 'Compra de ' . $cantidad . ' unidad(es) del producto "' . $product->nombre .'" por parte del comprador ' . $comprador->nombres . ' ' . $comprador->apellidos . '.';

		$compra = new Compra([
			'cantidad' => $cantidad,
			'valorTotal' => $valorTotal,
		]);

		$idOrden = $this->generateOrderId();
		while(!Compra::where('idOrden', $idOrden)->get()->isEmpty()) {
			$idOrden = $this->generateOrderId();
		}

		$compra->idOrden = $idOrden;
		$compra->comprador()->associate($comprador);
		$compra->product()->associate($product);
		$compra->metodoPago()->associate($metodoPago);
		$compra->estadoCompra()->associate(EstadoCompra::where('estado', 'pendiente')->get()->first());
		$compra->save();

		$solicitud = new Solicitud([
			'mensaje' => $description,
            'leidoComprador' => true,
		]);
		$tipo_solicitud = TipoSolicitud::where('tipo', 'compra')->get()->first();
		$solicitud->tipoSolicitud()->associate($tipo_solicitud);
		$solicitud->comprador()->associate($comprador);
		$solicitud->admin()->associate($product->admin);
		$solicitud->save();

		$compra->requests()->save($solicitud);

		$product->cantidad -= $cantidad;
		$product->save();

        $this->notifyPurchase($solicitud, $product);

		return redirect(route('purchase::response',$compra->idOrden));
			//->with('message-success', 'La compra se ha realizado ' .
			//'exitosamente, ahora debes esperar a que el administrador correspondiente se ponga en contacto contigo!');
    }

	/**
	 * Generate an order id of 10 random numeric characters.
	 *
	 * @return string
	 */
	private function generateOrderId()
    {
	    $faker = Faker::create();

	    return $faker->regexify('^\d{10}$');
    }

	/**
	 * Process the purchase request with payment method "Externo"
	 *
	 * @param Request    $request
	 * @param Producto   $product
	 * @param Comprador  $comprador
	 * @param MetodoPago $metodoPago
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function buyExterno(Request $request, Producto $product, Comprador $comprador, MetodoPago $metodoPago)
	{
		$cantidad = $request->cantidad;
		$ApiKey = env("PAYU_KEY", '4Vj8eK4rloUd272L48hsrarnUA');
		$merchantId = env("PAYU_MERCHANT_ID", '508029');
		$amount = $product->precioEmpaque * $cantidad;
		$description = 'Compra de ' . $cantidad . ' unidad(es) del producto "' . $product->nombre .'" por parte del comprador ' . $comprador->nombres . ' ' . $comprador->apellidos . '.';
		$buyerFullName = $comprador->nombres . ' ' . $comprador->apellidos;
		$buyerEmail = $comprador->correoElectronico;
		$shippingAddress = $comprador->direccion->direccion;
		$shippingCity = $comprador->direccion->ciudad;
		$shippingCountry = 'CO';
		$telephone = $comprador->telefono;
		$currency = 'COP';
		$algorithmSignature = 'SHA';
		$tax = $amount*0.19;
		$taxReturnBase = $amount;
		$valorTotal = $amount + $tax;
		$amount = number_format($valorTotal, 2, '.', '');

		$compra = new Compra([
			'cantidad' => $cantidad,
			'valorTotal' => $valorTotal,
		]);

		$idOrden = $this->generateOrderId();
		while(!Compra::where('idOrden', $idOrden)->get()->isEmpty()) {
			$idOrden = $this->generateOrderId();
		}

		$compra->idOrden = $idOrden;
		$compra->comprador()->associate($comprador);
		$compra->product()->associate($product);
		$compra->metodoPago()->associate($metodoPago);
		$compra->estadoCompra()->associate(EstadoCompra::where('estado', 'pendiente')->get()->first());
		$compra->save();

		$solicitud = new Solicitud([
			'mensaje' => $description,
			'leidoComprador' => true,
		]);
		$tipo_solicitud = TipoSolicitud::where('tipo', 'compra')->get()->first();
		$solicitud->tipoSolicitud()->associate($tipo_solicitud);
		$solicitud->comprador()->associate($comprador);
		$solicitud->admin()->associate($product->admin);
		$solicitud->save();

		$compra->requests()->save($solicitud);

		$product->cantidad -= $cantidad;
		$product->save();

		$referenceCode = 'PC-' . $compra->idOrden;

		$signature = "$ApiKey~$merchantId~$referenceCode~$amount~$currency";
		$signature = sha1($signature);
		$responseUrl = route('purchase::response', $compra->idOrden);
		$confirmationUrl = route('purchase::confirmation', $compra->idOrden);

		return view('purchases.buy', compact('amount', 'merchantId', 'referenceCode', 'description', 'buyerFullName', 'buyerEmail', 'shippingAddress', 'shippingCity', 'shippingCountry', 'telephone', 'currency', 'signature', 'algorithmSignature', 'tax', 'taxReturnBase', 'responseUrl', 'confirmationUrl'));
    }

	/**
	 * Trigger a Notification to the Admin about the purchase
	 *
	 * @param Solicitud $question
	 * @param Producto  $producto
	 */
    public function notifyPurchase(Solicitud $question, Producto $producto)
    {
        $notification = array(
            'notificacion' => 'Han realizado una nueva compra del producto "' . $producto->nombre . '".',
            'mensaje' => $question->mensaje,
            'tipo' => $question->tipoSolicitud->tipo,
            //'nombres' => $question->comprador->nombres,
            //'apellidos' => $question->comprador->apellidos,
            'href' => route('purchase::show',$question->requestable->idOrden),
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

	/**
	 * Trigger a Notification to the Admin about the refund request
	 *
	 * @param Solicitud $request
	 * @param Compra  $compra
	 */
	public function notifyRefund(Solicitud $request, Compra $compra)
	{
		$notification = array(
			'notificacion' => 'Han realizado una solicitud de devolución en la orden "' . $compra->idOrden . '".',
			'mensaje' => $request->mensaje,
			'tipo' => $request->tipoSolicitud->tipo,
			//'nombres' => $question->comprador->nombres,
			//'apellidos' => $question->comprador->apellidos,
			'href' => route('request::index'),
		);
		$channel = 'notifications_' . $request->admin->id;

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
