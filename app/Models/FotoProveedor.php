<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoProveedor extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fotoProveedor';

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
	 * Get the provider of the photo.
	 */
	public function proveedor()
	{
		return $this->belongsTo(Proveedor::class, 'idProveedor');
	}
}
