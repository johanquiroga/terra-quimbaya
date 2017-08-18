<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ecotopo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ecotopo';

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
     * Get the Providers that belongs to each range.
     */
    public function providers()
    {
        return $this->hasMany(Proveedor::class, 'idEcotopo');
    }
}
