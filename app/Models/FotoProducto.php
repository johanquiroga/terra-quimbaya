<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoProducto extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fotoProducto';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['nombreArchivo', 'path'];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Get the product of the photo.
	 */
	public function producto()
	{
		return $this->belongsTo(Producto::class, 'idProducto');
	}
}
