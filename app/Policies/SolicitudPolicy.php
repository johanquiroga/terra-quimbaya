<?php

namespace App\Policies;

use App\Models\Solicitud;
use App\Models\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class SolicitudPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	/**
	 * Determine if the logged user can have the answer request option.
	 *
	 * @param Usuario $user
	 *
	 * @return bool
	 */
	public function answerIndex(Usuario $user)
	{
		return $user->tipoUsuario === 'admin';
    }

	/**
	 * Determine if the given request can be answered by the user.
	 *
	 * @param Usuario   $user
	 * @param Solicitud $request
	 *
	 * @return bool
	 */
	public function answer(Usuario $user, Solicitud $request)
	{
		return $user->idCC === $request->idAdministrador;
	}

	/**
	 * Determine if the given request can be updated by the user.
	 *
	 * @param Usuario  $user
	 * @param Solicitud $request
	 *
	 * @return bool
	 */
	public function update(Usuario $user, Solicitud $request)
	{
		return $user->idCC === $request->idAdministrador;
	}
}
