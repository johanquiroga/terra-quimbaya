<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'devolucion';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['mensaje', 'respuesta'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'idCompra'];

	/**
	 * Get the purchases refund requests.
	 */
	public function requests()
	{
		return $this->morphOne(Solicitud::class, 'requestable');
	}

	/**
	 * Get the purchase related to the refund request.
	 */
	public function compra()
	{
		return $this->belongsTo(Compra::class, 'idCompra');
	}
}
