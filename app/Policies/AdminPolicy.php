<?php

namespace App\Policies;

use App\Models\Administrador;
use App\Models\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
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
	 * Determine if the given admin can be edited by the user.
	 *
	 * @param Usuario   $user
	 * @param Administrador $admin
	 *
	 * @return bool
	 */
	public function edit(Usuario $user, Administrador $admin)
	{
		return $user->idCC != $admin->id;
	}

	/**
	 * Determine if the given admin can be updated by the user.
	 *
	 * @param Usuario   $user
	 * @param Administrador $admin
	 *
	 * @return bool
	 */
	public function update(Usuario $user, Administrador $admin)
	{
		return $user->idCC != $admin->id;
	}

	/**
	 * Determine if the given admin can be deleted by the user.
	 *
	 * @param Usuario   $user
	 *
	 * @return bool
	 */
	public function destroy(Usuario $user)
	{
		return $user->tipoUsuario === 'root';
	}
}
