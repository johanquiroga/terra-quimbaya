<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Comprador
{
	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new middleware instance.
	 *
	 * @param  Guard $auth
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	if($this->auth->user()->tipoUsuario != 'comprador') {
		    if ($request->ajax() || $request->expectsJson()) {
			    return response('Forbidden action.', 403);
		    } else {
			    //Session::flash('message-error', 'Acción no autorizada');
			    //return back()->with('error-message', 'Acción no autorizada');
			    abort('403', 'Forbidden action.');
		    }
	    }
        return $next($request);
    }
}
