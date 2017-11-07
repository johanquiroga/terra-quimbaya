<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use App\Models\Comprador;
use App\Models\Root;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

	/**
	 * Get the password reset validation rules.
	 *
	 * @return array
	 */
	protected function rules()
	{
		return [
			'token' => 'required',
			'email' => "required|email|max:45|exists:usuario,email",
			'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
		];
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
	 * @param  string  $password
	 * @return void
	 */
	protected function resetPassword($user, $password)
	{
		$new_password = bcrypt($password);
		$user->password = $new_password;

		$user->setRememberToken(Str::random(60));

		$user->save();

		$id = $user->idCC;
		switch ($user->tipoUsuario) {
			case 'root':
				$usuario = Root::findOrFail($id);
				$usuario->contraseña = $new_password;
				$usuario->save();
				break;
			case 'comprador':
				$usuario = Comprador::findOrFail($id);
				$usuario->contraseña = $new_password;
				$usuario->save();
				break;
			case 'admin':
				$usuario = Administrador::findOrFail($id);
				$usuario->contraseña = $new_password;
				$usuario->save();
				break;
		}

		event(new PasswordReset($user));

		$this->guard()->login($user);
	}
}
