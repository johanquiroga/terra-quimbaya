<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Root extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'root';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['id', 'nombres', 'apellidos', 'correoElectronico', 'contraseña'];

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
}
