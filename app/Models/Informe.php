<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'informe';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fechaGeneracion', 'path'];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['fechaGeneracion'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Admin who created the report.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Administrador::class, 'idAdministrador');
    }
}
