<?php

namespace App\Providers;

use App\Models\Administrador;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Solicitud;
use App\Policies\AdminPolicy;
use App\Policies\CompraPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\ProveedorPolicy;
use App\Policies\SolicitudPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
	    Administrador::class => AdminPolicy::class,
        Proveedor::class => ProveedorPolicy::class,
        Producto::class => ProductoPolicy::class,
	    Solicitud::class => SolicitudPolicy::class,
	    Compra::class => CompraPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

	    Gate::define('delete-account', function ($user) {
		    return $user->tipoUsuario === 'comprador';
	    });
    }
}
