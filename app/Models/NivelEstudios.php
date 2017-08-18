<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelEstudios extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nivelEstudios';

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
     * Get the Providers that belongs to each Study grade type.
     */
    public function providers()
    {
        return $this->hasMany(Proveedor::class, 'idNivelEstudios');
    }

    /**
     * Get the Buyers that belongs to each Study grade type.
     */
    public function buyers()
    {
        return $this->hasMany(Comprador::class, 'idNivelEstudios');
    }
}
