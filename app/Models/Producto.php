<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'producto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'descripcion', 'cantidad', 'precioEmpaque'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'idAdministrador', 'idProveedor'];

	/**
	 * Get the product's name.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function getNombreAttribute($value)
	{
		return ucwords($value);
	}

	/**
	 * Set the product's name.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function setNombreAttribute($value)
	{
		$this->attributes['nombre'] = strtolower($value);
	}

	/**
	 * Scope a query to only include active products.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeEstado($query)
	{
		return $query->where('estado', 1);
	}

	/**
	 * Scope a query to only include products with the given coffee variety.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeVariedad($query, $variedad)
	{
		return $query->whereIn('idVariedadCafe', $variedad);
	}

	/**
	 * Scope a query to only include products where the given attribute has one of the given values.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeTieneAtributos($query, $atributo, $valores, $bool = 'and')
	{
		return $query->whereHas('atributos', function ($query) use ($valores, $atributo) {
			$query->where('nombreAtributo', $atributo)->whereIn('valorAtributo', $valores);
		});
	}

	/**
	 * Scope a query to only include products from providers from the given location.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeUbicacion($query, $ubicacion)
	{
		return $query->whereHas('proveedor', function ($query) use ($ubicacion) {
			$query->whereHas('ubicacionFinca', function ($query) use ($ubicacion) {
				$query->where('departamento', $ubicacion);
			});
		});
	}

	/**
	 * Scope a query to only include products within price range.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopePrecio($query, $min, $max)
	{
		if(isset($min) && isset($max)) {
			return $query->where('precioEmpaque', '>=', $min)->where('precioEmpaque', '<=', $max);
		}
	}

	/**
	 * Scope a query to only include products with name like the given value.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeNombre($query, $nombre)
	{
		if(trim($nombre) != "") {
			return $query->where('nombre', "LIKE", "%$nombre%")
				->orWhere('idPublicacion', "LIKE", "%$nombre%");
		}
	}

    /**
     * Get the coffee type of the product.
     */
    public function variedadCafe()
    {
        return $this->belongsTo(VariedadCafe::class, 'idVariedadCafe');
    }

    /**
     * Get the admin responsible for the product.
     */
    public function admin()
    {
        return $this->belongsTo(Administrador::class, 'idAdministrador');
    }

    /**
     * Get the provider that offers the product.
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor');
    }

    /**
     * Get the attributes of the product.
     */
    public function atributos()
    {
        return $this->belongsToMany(Atributo::class, 'productoTieneAtributo', 'idProducto',
            'idAtributo')
            ->withPivot('valorAtributo');
    }

	/**
	 * Get the photos of the product.
	 */
	public function fotos()
	{
		return $this->hasMany(FotoProducto::class, 'idProducto');
    }

    /**
     * Get the Questions associated to the product.
     */
	public function questions()
	{
		return $this->hasMany(PreguntaProducto::class, 'idProducto');
	}

	/**
	 * Get the Purchases made of this product.
	 */
	public function compras()
	{
		return $this->hasMany(Compra::class, 'idProducto');
	}

	/**
	 * Get the reviews of the product.
	 */
	public function calificaciones()
	{
		return $this->hasManyThrough(CalificacionProducto::class, Compra::class, 'idProducto',
			'idCompra');
	}

	/**
	 * Get the refund requests of the product.
	 */
	public function devoluciones()
	{
		return $this->hasManyThrough(Devolucion::class, Compra::class, 'idProducto',
			'idCompra');
	}
}
