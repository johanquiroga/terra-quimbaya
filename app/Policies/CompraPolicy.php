<?php

namespace App\Policies;

use App\Models\Compra;
use App\Models\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompraPolicy
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
	 * Determine if the given purchase details can be seen by the user.
	 *
	 * @param Usuario $user
	 * @param Compra  $purchase
	 *
	 * @return bool
	 */
	public function show(Usuario $user, Compra $purchase)
	{
		return $user->idCC === $purchase->product->idAdministrador || $user->idCC === $purchase->idComprador;
	}

	/**
	 * Determine if the given purchase response state can be seen by the user.
	 *
	 * @param Usuario $user
	 * @param Compra  $purchase
	 *
	 * @return bool
	 */
	public function response(Usuario $user, Compra $purchase)
	{
		return $user->idCC === $purchase->idComprador;
	}

	/**
	 * Determine if the given purchase can be reviewed by the user.
	 *
	 * @param Usuario $user
	 * @param Compra  $purchase
	 *
	 * @return bool
	 */
	public function review(Usuario $user, Compra $purchase)
	{
		return $user->idCC === $purchase->idComprador;
	}

	/**
	 * Determine if a refund on the given purchase can be by requested by the user.
	 *
	 * @param Usuario $user
	 * @param Compra  $purchase
	 *
	 * @return bool
	 */
	public function refund(Usuario $user, Compra $purchase)
	{
		return $purchase->estadoCompra->estado === 'aceptada' && $user->idCC === $purchase->idComprador;
	}

	/**
	 * Determine if a refund on the given purchase can be by requested by the user.
	 *
	 * @param Usuario $user
	 * @param Compra  $purchase
	 *
	 * @return bool
	 */
	public function sendRefund(Usuario $user, Compra $purchase)
	{
		return $purchase->estadoCompra->estado === 'aceptada' && $user->idCC === $purchase->idComprador;
	}

	/**
	 * Determine if the given purchase review can be edited by the user.
	 *
	 * @param Usuario $user
	 * @param Compra  $purchase
	 *
	 * @return bool
	 */
	public function editReview(Usuario $user, Compra $purchase)
	{
		return $user->idCC === $purchase->idComprador;
	}

	/**
	 * Determine if the given purchase review can be updated by the user.
	 *
	 * @param Usuario $user
	 * @param Compra  $purchase
	 *
	 * @return bool
	 */
	public function updateReview(Usuario $user, Compra $purchase)
	{
		return $user->idCC === $purchase->idComprador;
	}
}
