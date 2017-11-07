<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*
|--------------------------------------------------------------------------
| Home Routes
|--------------------------------------------------------------------------
|
 */

Route::get('/home', 'HomeController@index');
Route::get('/search', 'HomeController@search');

/*
|--------------------------------------------------------------------------
|  Products management routes
|--------------------------------------------------------------------------
|
 */
Route::group(['as' => 'product::', 'prefix' => 'product'], function() {
	Route::group(['middleware' => 'auth:api'], function () {

		Route::group(['middleware' => 'comprador'], function () {
			Route::post('postQuestion/{id}', [
				'as'   => 'postQuestion',
				'uses' => 'ProductoController@postQuestion'
			]);
		});
	});

	Route::get('{id}', [
		'as' => 'show',
		'uses' => 'ProductoController@show'
	]);
});

/*
|--------------------------------------------------------------------------
|  Providers management routes
|--------------------------------------------------------------------------
|
 */
Route::group(['as' => 'provider::', 'prefix' => 'provider'], function() {
	Route::get('{id}', [
		'as' => 'show',
		'uses' => 'ProveedorController@show'
	]);
});

/*
|--------------------------------------------------------------------------
| Authentication routes
|--------------------------------------------------------------------------
|
 */

Route::post('/login', 'Api\AuthController@login');
Route::group(['middleware' => ['auth:api']], function () {
	Route::get('/logout', 'Api\AuthController@logout');
});

Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('/register', 'Auth\RegisterController@register');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
|
 */
Route::group(['middleware' => ['auth:api', 'comprador'], 'prefix' => 'user'], function () {
	Route::get('', 'Api\AuthController@details');
	Route::put('/{id}', 'ProfileController@update');
	Route::delete('/{id}', 'ProfileController@destroy');
});

/*
|--------------------------------------------------------------------------
| Miscellaneous Routes
|--------------------------------------------------------------------------
|
 */
Route::get('country', 'Auth\RegisterController@getCountry')->name('country');
Route::get('departments/{country}', 'Auth\RegisterController@getDepartment')->name('departments');
Route::get('cities/{department}', 'Auth\RegisterController@getCity')->name('cities');