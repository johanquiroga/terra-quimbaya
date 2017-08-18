<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use App\Models\Comprador;
use App\Models\Root;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use function foo\func;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
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
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected $subject = 'Restablecer contraseña.';

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmail()
    {
        return view('auth.passwords.email');
    }

    /**
     * Verify the email given to request a password reset link.
     *
     * @return JsonResponse
     */
    public function verifyEmail(Request $request, $email)
    {
        //echo $email;
        //$valid = Usuario::where('email', '=', $email)->get()->isEmpty();
        //dd(response()->json($valid));
        if($request->ajax()) {
            $valid = Usuario::where('email', '=', $email)->get()->isEmpty();
            return response()->json($valid);
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('auth.passwords.reset')->with('token', $token);
    }

	/**
	 * Send a reset link to the given user.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postEmail(Request $request)
	{
		$this->validate($request, ['email' => 'required|email|max:45']);

		$response = Password::sendResetLink($request->only('email'), function (Message $message) {
			$message->subject($this->getEmailSubject());
		});

		switch ($response) {
			case Password::RESET_LINK_SENT:
				return redirect(url('/'))->with('message-success', trans($response));
			case Password::INVALID_USER:
				return redirect()->back()->withErrors(['email' => trans($response)]);
		}
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postReset(Request $request)
	{
		$this->validate($request, [
			'token' => 'required',
			'email' => "required|email|max:45|exists:usuario,email",
			'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
		]);

		$credentials = $request->only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function ($user, $password) {
			$this->resetPassword($user, $password);
		});

		switch ($response) {
			case Password::PASSWORD_RESET:
				return redirect(route('profile::profile'))->with('message-success', trans($response));
			default:
				return redirect()->back()
					->withInput($request->only('email'))
					->withErrors(['email' => trans($response)]);
		}
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

		Auth::login($user);
	}
}
