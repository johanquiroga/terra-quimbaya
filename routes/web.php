<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Home Routes
|--------------------------------------------------------------------------
|
 */

Route::get('/', 'HomeController@index')->name('home');
Route::get('/search', 'HomeController@search');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
|
 */
Route::group(['as' => 'profile::', 'middleware' => 'auth', 'prefix' => 'profile'], function () {
	Route::get('', [
		'as' => 'profile',
		'uses' => 'ProfileController@index'
	]);
	Route::post('update/{id}', [
		'as' => 'update',
		'uses' => 'ProfileController@update'
	]);
	Route::post('destroy', [
		'as' => 'destroy',
		'uses' => 'ProfileController@destroy'
	]);
});

/*
|--------------------------------------------------------------------------
| Authentication routes
|--------------------------------------------------------------------------
|
 */

Route::get('/logout', 'Auth\LoginController@logout');
Auth::routes();

//Route::get('auth/login', [
//	'as' => 'login', 'uses' => 'Auth\AuthController@getLogin'
//]);
//Route::post('auth/login', [
//	'as' => 'login', 'uses' => 'Auth\AuthController@postLogin'
//]);
//Route::get('auth/logout', [
//	'as' => 'logout', 'uses' => 'Auth\AuthController@getLogout'
//]);

/*
|--------------------------------------------------------------------------
| Registration routes
|--------------------------------------------------------------------------
|
 */
//Route::get('auth/register', [
//	'as' => 'register', 'uses' => 'Auth\AuthController@getRegister'
//]);
//Route::post('auth/register', [
//	'as' => 'register', 'uses' => 'Auth\AuthController@postRegister'
//]);

/*
|--------------------------------------------------------------------------
| Password reset link request routes
|--------------------------------------------------------------------------
|
 */
//Route::get('password/email', 'Auth\PasswordController@getEmail');
//Route::get('password/email/{email}', 'Auth\PasswordController@verifyEmail');
//Route::post('password/email', 'Auth\PasswordController@postEmail');

/*
|--------------------------------------------------------------------------
| Password reset routes
|--------------------------------------------------------------------------
|
 */
//Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
//Route::post('password/reset', 'Auth\PasswordController@postReset');

/*
|--------------------------------------------------------------------------
|  Admins management routes
|--------------------------------------------------------------------------
|
 */
Route::group(['as' => 'admin::', 'middleware' => ['auth', 'admin:admin'], 'prefix' => 'admins'], function() {
	Route::get('', [
		'as' => 'index',
		'uses' => 'AdministradorController@index'
	]);
	Route::get('admin', [
		'as' => 'search',
		'uses' => 'AdministradorController@anyData'
	]);
	Route::get('create', [
		'as' => 'create',
		'uses' => 'AdministradorController@create'
	]);
	Route::post('store', [
		'as' => 'store',
		'uses' => 'AdministradorController@store'
	]);
	Route::get('edit/{id}', [
		'as' => 'edit',
		'uses' => 'AdministradorController@edit'
	]);
	Route::post('update/{id}', [
		'as' => 'update',
		'uses' => 'AdministradorController@update'
	]);
	Route::post('destroy', [
		'as' => 'destroy',
		'uses' => 'AdministradorController@destroy'
	]);
});

/*
|--------------------------------------------------------------------------
|  Providers management routes
|--------------------------------------------------------------------------
|
 */
Route::group(['as' => 'provider::', 'prefix' => 'providers'], function() {
	Route::group(['middleware' => 'auth'], function () {
		Route::group(['middleware' => 'admin:provider'], function () {
			Route::get('', [
				'as' => 'index',
				'uses' => 'ProveedorController@index'
			]);
			Route::get('provider', [
				'as' => 'search',
				'uses' => 'ProveedorController@anyData'
			]);
			Route::get('create', [
				'as' => 'create',
				'uses' => 'ProveedorController@create'
			]);
			Route::post('store', [
				'as' => 'store',
				'uses' => 'ProveedorController@store'
			]);
			Route::get('edit/{id}', [
				'as' => 'edit',
				'uses' => 'ProveedorController@edit'
			]);
			Route::post('update/{id}', [
				'as' => 'update',
				'uses' => 'ProveedorController@update'
			]);
			Route::post('destroy', [
				'as' => 'destroy',
				'uses' => 'ProveedorController@destroy'
			]);
		});
	});

	Route::get('show/{id}', [
		'as' => 'show',
		'uses' => 'ProveedorController@show'
	]);
});

/*
|--------------------------------------------------------------------------
|  Products management routes
|--------------------------------------------------------------------------
|
 */
Route::group(['as' => 'product::', 'prefix' => 'products'], function() {
	Route::group(['middleware' => 'auth'], function () {
		Route::group(['middleware' => 'admin:product'], function () {
			Route::get('', [
				'as' => 'index',
				'uses' => 'ProductoController@index'
			]);
			Route::get('provider', [
				'as' => 'search',
				'uses' => 'ProductoController@anyData'
			]);
			Route::get('create', [
				'as' => 'create',
				'uses' => 'ProductoController@create'
			]);
			Route::post('store', [
				'as' => 'store',
				'uses' => 'ProductoController@store'
			]);
			Route::get('edit/{id}', [
				'as' => 'edit',
				'uses' => 'ProductoController@edit'
			]);
			Route::post('update/{id}', [
				'as' => 'update',
				'uses' => 'ProductoController@update'
			]);
			Route::post('destroy', [
				'as' => 'destroy',
				'uses' => 'ProductoController@destroy'
			]);
		});

		Route::group(['middleware' => 'comprador'], function () {
			Route::post('postQuestion/{id}', [
				'as'   => 'postQuestion',
				'uses' => 'ProductoController@postQuestion'
			]);
		});
	});

	Route::get('show/{id}', [
		'as' => 'show',
		'uses' => 'ProductoController@show'
	]);
});

/*
|--------------------------------------------------------------------------
|  Requests management routes
|--------------------------------------------------------------------------
|
 */
Route::group(['as' => 'request::', 'middleware' => ['auth'], 'prefix' => 'requests'], function() {

	Route::group(['middleware' => 'admin_comprador'], function () {
		Route::get('', [
			'as' => 'index',
			'uses' => 'SolicitudController@index'
		]);
		Route::get('request', [
			'as' => 'search',
			'uses' => 'SolicitudController@anyData'
		]);
	});

	Route::group(['middleware' => 'comprador'], function () {
		Route::get('index/{id}', [
			'as' => 'indexBuyer',
			'uses' => 'SolicitudController@indexBuyer'
		]);
	});

	Route::group(['middleware' => ['admin:request']], function() {
		Route::get('answer/{id}', [
			'as' => 'answer',
			'uses' => 'SolicitudController@answer'
		]);
		Route::post('update/{id}', [
			'as' => 'update',
			'uses' => 'SolicitudController@update'
		]);
	});
});

/*
|--------------------------------------------------------------------------
|  Purchases management routes
|--------------------------------------------------------------------------
|
 */
Route::group(['as' => 'purchase::', 'prefix' => 'purchases'], function () {

	Route::group(['middleware' => ['auth']], function () {
		Route::group(['middleware' => ['comprador']], function() {
			Route::get('buy/{id}', [
				'as' => 'buy',
				'uses' => 'CompraController@buy'
			]);
			Route::get('response/{id}', [
				'as' => 'response',
				'uses' => 'CompraController@response'
			]);
			Route::post('review/{id}', [
				'as' => 'review',
				'uses' => 'CompraController@review'
			]);
			Route::get('review/{id}/edit', [
				'as' => 'review::edit',
				'uses' => 'CompraController@editReview'
			]);
			Route::post('review/{id}/update', [
				'as' => 'review::update',
				'uses' => 'CompraController@updateReview'
			]);
			Route::get('refund/{id}', [
				'as' => 'refund',
				'uses' => 'CompraController@refund'
			]);
			Route::post('refund/{id}', [
				'as' => 'refund',
				'uses' => 'CompraController@sendRefund'
			]);
		});
		Route::group(['middleware' => 'admin_comprador'], function () {
			Route::get('show/{id}', [
				'as' => 'show',
				'uses' => 'CompraController@show'
			]);
		});
	});

	Route::post('confirmation/{id}', [
		'as' => 'confirmation',
		'uses' => 'CompraController@confirmation'
	]);
});

/*
|--------------------------------------------------------------------------
|  Reports management routes
|--------------------------------------------------------------------------
|
 */
Route::group(['as' => 'report::', 'middleware' => ['auth', 'admin:reports'], 'prefix' => 'reports'], function () {

	Route::get('', [
		'as' => 'index',
		'uses' => 'InformeController@index'
	]);
	Route::get('create', [
		'as' => 'create',
		'uses' => 'InformeController@create'
	]);
	Route::get('request', [
		'as' => 'search',
		'uses' => 'InformeController@anyData'
	]);
	Route::get('download/{id}', [
		'as' => 'download',
		'uses' => 'InformeController@download'
	]);
	Route::post('store', [
		'as' => 'store',
		'uses' => 'InformeController@store'
	]);
});

/*
|--------------------------------------------------------------------------
|  File service routes
|--------------------------------------------------------------------------
|
 */
Route::group(['as' => 'storage::', 'prefix' => 'storage'], function () {
	Route::group(['middleware' => ['auth','admin:report']], function () {
		Route::get('get/{filename}/{download}', [
			'as' => 'download',
			'uses' => 'FileController@get'
		])->where('filename', '(.*)\.pdf');
	});

	Route::get('get/{filename}', [
		'as' => 'get',
		'uses' => 'FileController@get'
	])->where('filename', '^(.*)[^\.pdf]$');
});
