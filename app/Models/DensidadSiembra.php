<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DensidadSiembra extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'densidadSiembra';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tipo'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Providers that belongs to this density type.
     */
    public function providers()
    {
        return $this->hasMany(Proveedor::class, 'idDensidadSiembra');
    }
}
