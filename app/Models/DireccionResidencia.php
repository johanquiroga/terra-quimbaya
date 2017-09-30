<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DireccionResidencia extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'direccionResidencia';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['direccion', 'direccionAuxiliar', 'codigoPostal', 'ciudad', 'departamento', 'pais', 'idComprador'];

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
	protected $hidden = ['id', 'idComprador'];

    /**
     * Get the user that owns the address.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idComprador');
    }
}
