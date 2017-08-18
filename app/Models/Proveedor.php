<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proveedor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'nombres', 'apellidos', 'nombreFinca', 'edadProveedor', 'telefono',
        'alturaFinca', 'extensionFinca', 'extensionLotes', 'añosCafetal', 'nucleoFamiliar',
        'personasDependientesFinca'];

	/**
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * Scope a query to only include active providers.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeEstado($query)
	{
		return $query->where('estado', 1);
	}

	/**
	 * Scope a query to only providers with names like the given value.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeNombre($query, $nombre)
	{
		if(trim($nombre) != "") {
			return $query->where('nombres', "LIKE", "%$nombre%");
		}
	}

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
	 * Get the user's farm name.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function getNombreFincaAttribute($value)
	{
		return ucwords($value);
	}

	/**
	 * Set the user's farm name.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function setNombreFincaAttribute($value)
	{
		$this->attributes['nombreFinca'] = strtolower($value);
	}

    /**
     * Get the farm location.
     */
    public function ubicacionFinca()
    {
        return $this->hasOne(UbicacionFinca::class, 'idProveedor');
    }

    /**
     * Get the density of sowing.
     */
    public function densidadSiembra()
    {
        return $this->belongsTo(DensidadSiembra::class, 'idDensidadSiembra');
    }

    /**
     * Get the age.
     */
    public function edadUltimaZoca()
    {
        return $this->belongsTo(EdadUltimaZoca::class, 'idEdadUltimaZoca');
    }

    /**
     * Get the benefit type.
     */
    public function tipoBeneficio()
    {
        return $this->belongsTo(TipoBeneficio::class, 'idTipoBeneficio');
    }

    /**
     * Get the ecotopo's farm.
     */
    public function ecotopo()
    {
        return $this->belongsTo(Ecotopo::class, 'idEcotopo');
    }

    /**
     * Get the study grade of provider.
     */
    public function nivelEstudios()
    {
        return $this->belongsTo(NivelEstudios::class, 'idNivelEstudios');
    }

    /**
     * Get the products that the provider offers.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'idProveedor');
    }

	/**
	 * Get the admin responsible for the provider
	 */
	public function admin()
	{
		return $this->belongsTo(Administrador::class, 'idAdministrador');
    }

	/**
	 * Get the coffee varieties of the provider.
	 */
	public function variedadesCafe()
	{
		return $this->belongsToMany(VariedadCafe::class, 'proveedorTieneVariedad', 'idProveedor',
			'idVariedadCafe');
	}

	/**
	 * Get the photos of the provider.
	 */
	public function fotos()
	{
		return $this->hasMany(FotoProveedor::class, 'idProveedor');
	}
}
