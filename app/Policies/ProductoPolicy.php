<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductoPolicy
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
	 * Determine if the given product can be edited by the user.
	 *
	 * @param Usuario  $user
	 * @param Producto $product
	 *
	 * @return bool
	 */
	public function edit(Usuario $user, Producto $product)
	{
		return $user->idCC === $product->idAdministrador;
	}

	/**
	 * Determine if the given product can be updated by the user.
	 *
	 * @param Usuario  $user
	 * @param Producto $product
	 *
	 * @return bool
	 */
	public function update(Usuario $user, Producto $product)
	{
		return $user->idCC === $product->idAdministrador;
	}

	/**
	 * Determine if the logged user can post questions on products.
	 *
	 * @param Usuario  $user
	 * @param Producto $product
	 *
	 * @return bool
	 */
	public function postQuestion(Usuario $user, Producto $product)
	{
		return $user->tipoUsuario === 'comprador';
	}

	/**
	 * Determine if the logged user can buy products.
	 *
	 * @param Usuario  $user
	 * @param Producto $product
	 *
	 * @return bool
	 */
	public function buy(Usuario $user, Producto $product)
	{
		return $user->tipoUsuario === 'comprador';
	}

	/**
	 * Determine if the given product can be deleted by the user.
	 *
	 * @param Usuario  $user
	 * @param Producto $product
	 *
	 * @return bool
	 */
	public function destroy(Usuario $user, Producto $product)
	{
		return $user->idCC === $product->idAdministrador;
	}
}
