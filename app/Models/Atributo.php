<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atributo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'atributo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombreAtributo', 'descripcionAtributo'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['created_at', 'updated_at', 'id', 'pivot.idProducto'];

    /**
     * Get the products that have the attribute.
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'productoTieneAtributo', 'idAtributo',
            'idProducto')
            ->withPivot('valorAtributo');
    }

    /**
     * Get the Buyers that have the attribute.
     */
    public function buyers()
    {
        return $this->belongsToMany(Comprador::class, 'compradorTienePreferencia', 'idAtributo',
            'idComprador')
            ->withPivot('valorAtributo');
    }
}
