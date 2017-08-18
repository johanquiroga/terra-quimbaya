<?php

namespace App\Policies;

use App\Models\Proveedor;
use App\Models\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProveedorPolicy
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
	 * Determine if the given provider can be edited by the user.
	 *
	 * @param Usuario   $user
	 * @param Proveedor $provider
	 *
	 * @return bool
	 */
	public function edit(Usuario $user, Proveedor $provider)
	{
		return $user->idCC === $provider->idAdministrador;
	}

	/**
	 * Determine if the given provider can be updated by the user.
	 *
	 * @param Usuario   $user
	 * @param Proveedor $provider
	 *
	 * @return bool
	 */
	public function update(Usuario $user, Proveedor $provider)
	{
		return $user->idCC === $provider->idAdministrador;
	}

	/**
	 * Determine if the given provider can be deleted by the user.
	 *
	 * @param Usuario   $user
	 * @param Proveedor $provider
	 *
	 * @return bool
	 */
	public function destroy(Usuario $user, Proveedor $provider)
	{
		return $user->idCC === $provider->idAdministrador;
	}
}
