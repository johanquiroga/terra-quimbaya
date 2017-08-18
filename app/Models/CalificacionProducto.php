<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionProducto extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'calificacionProducto';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['calificacion', 'comentario'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['idCompra'];

	/**
	 * Get the purchase that owns the review.
	 */
	public function compra()
	{
		return $this->belongsTo(Compra::class, 'idCompra');
	}
}
