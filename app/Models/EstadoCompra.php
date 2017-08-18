<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoCompra extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'estadoCompra';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['estado'];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Get the purchases that belongs to this purchase state.
	 */
	public function compras()
	{
		return $this->hasMany(Compra::class, 'idEstadoCompra');
	}
}
