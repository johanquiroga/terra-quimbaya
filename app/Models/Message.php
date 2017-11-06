<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'message',
	];

	/**
	 * Get the user's name.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function getNameAttribute($value)
	{
		return ucwords($value);
	}

	/**
	 * Set the user's name.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function setNameAttribute($value)
	{
		$this->attributes['name'] = strtolower($value);
	}
}
