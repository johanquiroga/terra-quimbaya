<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comprador extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comprador';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'nombres', 'apellidos', 'correoElectronico', 'contraseña', 'telefono'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['contraseña'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

	/**
	 * Get the user's name.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function getNombresAttribute($value)
	{
		return ucwords($value);
	}

	/**
	 * Set the user's name.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function setNombresAttribute($value)
	{
		$this->attributes['nombres'] = strtolower($value);
	}

	/**
	 * Get the user's last name.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function getApellidosAttribute($value)
	{
		return ucwords($value);
	}

	/**
	 * Set the user's last name.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function setApellidosAttribute($value)
	{
		$this->attributes['apellidos'] = strtolower($value);
	}

    /**
     * Get the address associated with the user.
     */
    public function direccion()
    {
        return $this->hasOne(DireccionResidencia::class, 'idComprador');
    }

    /**
     * Get the buyer's coffee purchase frequency.
     */
    public function frecuenciaCompraCafe()
    {
        return $this->belongsTo(FrecuenciaCompraCafe::class, 'idFrecuenciaCompraCafe');
    }

    /**
     * Get the buyer's studies level.
     */
    public function nivelEstudios()
    {
        return $this->belongsTo(NivelEstudios::class, 'idNivelEstudios');
    }

    /**
     * Get the preferred coffee attributes.
     */
    public function atributos()
    {
        return $this->belongsToMany(Atributo::class, 'compradorTienePreferencia', 'idComprador',
            'idAtributo')
            ->withPivot('valorAtributo');
    }

    /**
     * Get the Questions asked by the user.
     */
    public function questions()
    {
        return $this->hasMany(PreguntaProducto::class, 'idComprador');
    }

	/**
	 * Get the Requests made by the user.
	 */
	public function solicitudes()
	{
		return $this->hasMany(Solicitud::class, 'idComprador');
    }

	/**
	 * Get the Purchases made by the user.
	 */
	public function compras()
	{
		return $this->hasMany(Compra::class, 'idComprador');
	}

	/**
	 * Get the reviews made by the user.
	 */
	public function calificaciones()
	{
		return $this->hasManyThrough(CalificacionProducto::class, Compra::class, 'idComprador',
			'idCompra');
	}

	/**
	 * Get the refund requests made by the user.
	 */
	public function devoluciones()
	{
		return $this->hasManyThrough(Devolucion::class, Compra::class, 'idComprador',
			'idCompra');
	}
}
