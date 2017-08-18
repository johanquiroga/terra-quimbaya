<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'solicitud';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['mensaje', 'respuesta', 'leidoAdmin', 'leidoComprador'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['requestable_id'];

	/**
	 * Get the request type.
	 */
	public function tipoSolicitud()
	{
		return $this->belongsTo(TipoSolicitud::class, 'idTipoSolicitud');
	}

	/**
	 * Get the Buyer who made the request.
	 */
	public function comprador()
	{
		return $this->belongsTo(Comprador::class, 'idComprador');
	}

	/**
	 * Get the admin responsible for the request.
	 */
	public function admin()
	{
		return $this->belongsTo(Administrador::class, 'idAdministrador');
	}

	/**
	 * Get all of the owning requestable models.
	 */
	public function requestable()
	{
		return $this->morphTo();
	}
}
