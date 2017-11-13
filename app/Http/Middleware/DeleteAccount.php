<?php

namespace App\Http\Middleware;

use Closure;

class DeleteAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = null;
        $user = $request->user();
        if($request->has('id')) {
            $id = $request->id;
        } elseif ($request->route('id')) {
            $id = $request->route('id');
        }
        if (is_null($id) || ($id !== $user->idCC)) {
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
