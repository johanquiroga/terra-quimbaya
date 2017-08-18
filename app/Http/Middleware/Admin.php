<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Contracts\Auth\Guard;

class Admin
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
     * @param   string  $resource
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $resource)
    {
        if($this->auth->user()->tipoUsuario != 'admin') {
            if ($resource === 'admin') {
                if($this->auth->user()->tipoUsuario != 'root') {
                    if ($request->ajax()) {
                        return response('Forbidden action.', 403);
                    } else {
                        //Session::flash('message-error', 'Acción no autorizada');
                        //return back()->with('error-message', 'Acción no autorizada');
                        abort('403', 'Forbidden action.');
                    }
                }
            } else {
                if ($request->ajax()) {
                    return response('Forbidden action.', 403);
                } else {
                    //Session::flash('message-error', 'Acción no autorizada');
                    //return back()->with('error-message', 'Acción no autorizada');
                    abort('403', 'Forbidden action.');
                }
            }
        }
        return $next($request);
    }
}
