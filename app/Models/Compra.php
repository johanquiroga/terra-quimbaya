<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'compra';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['cantidad', 'valorTotal'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'idProducto'];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['fechaDeCompra'];

	/**
	 * Get the purchase state.
	 */
	public function estadoCompra()
	{
		return $this->belongsTo(EstadoCompra::class, 'idEstadoCompra');
	}

	/**
	 * Get the purchase payment method used.
	 */
	public function metodoPago()
	{
		return $this->belongsTo(MetodoPago::class, 'idMetodoPago');
	}

	/**
	 * Get the Buyer who bought the product.
	 */
	public function comprador()
	{
		return $this->belongsTo(Comprador::class, 'idComprador');
	}

	/**
	 * Get the Product related to the purchase.
	 */
	public function product()
	{
		return $this->belongsTo(Producto::class, 'idProducto');
	}

	/**
	 * Get the products purchases requests.
	 */
	public function requests()
	{
		return $this->morphOne(Solicitud::class, 'requestable');
	}

	/**
	 * Get the review associated with the purchase.
	 */
	public function calificacion()
	{
		return $this->hasOne(CalificacionProducto::class, 'idCompra');
	}

	/**
	 * Get the refund requests associated with the purchase.
	 */
	public function devoluciones()
	{
		return $this->hasMany(Devolucion::class, 'idCompra');
	}
}
