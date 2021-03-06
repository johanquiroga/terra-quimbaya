<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UbicacionFinca extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ubicacionFinca';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['vereda', 'corregimiento', 'ciudad', 'departamento', 'pais', 'idProveedor'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'idProveedor'];

    /**
     * Get the Provider's farm location.
     */
    public function provider()
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor');
    }

    /**
     * Get the vereda from farm location.
     *
     * @param  string  $value
     * @return string
     */
    public function getVeredaAttribute($value)
    {
        return $value ? ucwords($value) : '';
    }

    /**
     * Get the corregimiento from farm location.
     *
     * @param  string  $value
     * @return string
     */
    public function getCorregimientoAttribute($value)
    {
        return $value ? ucwords($value) : '';
    }
}
