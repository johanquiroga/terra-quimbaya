<?php

namespace App\Http\Controllers\Api;

use App\Models\Administrador;
use App\Models\Comprador;
use App\Models\Root;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function username()
	{
		return 'email';
	}

	/**
	 * Validate the user login request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return void
	 */
	protected function validateLogin(Request $request)
	{
		$this->validate($request, [
			$this->username() => 'required|string',
			'password' => 'required|string',
		]);
	}

	public function login(Request $request)
	{
		$credentials = $request->only($this->username(), 'password');

		try {
			// attempt to verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['status' => 'failed', 'error' => 'invalid_credentials', 'message' => trans('auth.failed')], 401);
			}
		} catch (JWTException $e) {
			// something went wrong whilst attempting to encode the token
			return response()->json(['status' => 'failed', 'error' => 'could_not_create_token'], 500);
		}

		// all good so return the token
		return response()->json(array_merge(['status' => 'success'], compact('token')));
    }

	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		Auth::guard('api')->logout();

		return response()->json(['status' => 'success', 'message' => 'User logged out']);
	}


	public function details(Request $request)
	{
		$user = Auth::guard('api')->user();
		$role = $user->tipoUsuario;
		$data = null;
		switch ($role) {
			case 'root':
				$data = Root::find($user->idCC);
				break;
			case 'comprador':
				$data = Comprador::find($user->idCC);
				break;
			case 'admin':
				$data = Administrador::find($user->idCC);
				break;
		}

		return response()->json(array_merge(['status' => 'success'], compact('data')));
	}
}
