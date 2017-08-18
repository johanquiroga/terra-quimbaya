<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class LayoutComposer
{

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $user = null;
        $checked = false;
        $notify = false;
        $notifications = null;
        if(Auth::check()) {
            $checked = true;
            $role = Auth::user()->tipoUsuario;
            //dd(Auth::user());
            switch ($role) {
                case 'root':
                    $user = \App\Models\Root::where('id', '=', Auth::user()->idCC)->get()->first();
                    break;
                case 'comprador':
                    $user = \App\Models\Comprador::where('id', '=', Auth::user()->idCC)->get()->first();
                    $notify = true;
                    $notifications = $user->solicitudes->where('leidoComprador', '=', false);
                    break;
                case 'admin':
                    $user = \App\Models\Administrador::where('id', '=', Auth::user()->idCC)->get()->first();
                    $notify = true;
                    $notifications = $user->solicitudes->where('leidoAdmin', '=', false);
                    break;
            }
//            $user = \App\Models\Comprador::where('id', '=', Auth::user()->id)->get()->first();
        }
        $view->with(compact('checked','user', 'notify', 'notifications'));
    }
}