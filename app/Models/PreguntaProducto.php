<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaProducto extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'preguntaProducto';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['consulta', 'respuesta'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['idProducto'];

	/**
	 * Get the Buyer who asked the question.
	 */
	public function buyer()
	{
		return $this->belongsTo(Comprador::class, 'idComprador');
	}

	/**
	 * Get the Product related to the question.
	 */
	public function product()
	{
		return $this->belongsTo(Producto::class, 'idProducto');
	}

	/**
	 * Get the product's questions requests.
	 */
	public function requests()
	{
		return $this->morphOne(Solicitud::class, 'requestable');
	}
}
