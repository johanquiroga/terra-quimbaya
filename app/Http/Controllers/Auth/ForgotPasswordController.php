<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
	 * Validate the email for the given request.
	 *
	 * @param \Illuminate\Http\Request  $request
	 * @return void
	 */
	protected function validateEmail(Request $request)
	{
		$this->validate($request, ['email' => 'required|email|max:45']);
	}

	/**
	 * Get the response for a successful password reset link.
	 *
	 * @param  string  $response
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function sendResetLinkResponse($response)
	{
		return back()->with('message-success', trans($response));
	}

	/**
	 * Get the response for a failed password reset link.
	 *
	 * @param  \Illuminate\Http\Request
	 * @param  string  $response
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function sendResetLinkFailedResponse(Request $request, $response)
	{
		return back()->with('message-error', trans($response))
			->withErrors(['email' => trans($response)]);
	}
}
