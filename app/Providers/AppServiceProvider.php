<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	    Validator::extend('greater_equal', function($attribute, $value, $parameters, $validator) {
		    $min = $parameters[0];
	    	return $value >= $min;
	    });
	    Validator::extend('less_equal', function($attribute, $value, $parameters, $validator) {
		    $min = $parameters[0];
		    return $value <= $min;
	    });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
