<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'administrador';

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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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
	 * Scope a query to only include active admins.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeEstado($query)
	{
		return $query->where('estado', 1);
	}

    /**
     * Get the products that the admin is responsible for.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'idAdministrador');
    }

	/**
	 * Get the providers that the admin is responsible for.
	 */
	public function proveedores()
	{
		return $this->hasMany(Proveedor::class, 'idAdministrador');
    }

	/**
	 * Get the requests that the admin is responsible for.
	 */
	public function solicitudes()
	{
		return $this->hasMany(Solicitud::class, 'idAdministrador');
	}

    /**
     * Get the Reports generated by this user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Informe::class, 'idAdministrador');
    }
}
