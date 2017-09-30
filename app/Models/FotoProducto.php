<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

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
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['idProducto'];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = ['url'];

	/**
	 * Get the product of the photo.
	 */
	public function producto()
	{
		return $this->belongsTo(Producto::class, 'idProducto');
	}

	/**
	 * Get the photo's public url.
	 *
	 * @return bool
	 */
	public function getUrlAttribute()
	{
		$filename = $this->attributes['path'].'/'.$this->attributes['nombreArchivo'];
		return Storage::url("$filename");
	}
}
