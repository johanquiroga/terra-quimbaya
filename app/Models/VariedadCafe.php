<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariedadCafe extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'variedadCafe';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['tipo'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'pivot'];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Get the products that belongs to this coffee type.
	 */
	public function products()
	{
		return $this->hasMany(Producto::class, 'idVariedadCafe');
	}

	/**
	 * Get the providers that offer this coffee variety.
	 */
	public function providers()
	{
		return $this->belongsToMany(Proveedor::class, 'proveedorTieneVariedad', 'idVariedadCafe',
			'idProveedor');
	}
}
