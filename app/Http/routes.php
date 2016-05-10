<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]
    ],
    function()
    {
        Route::get('/', [
            'uses' => 'Marketing\HomeController@index',
            'as' => 'index',
        ]);

        Route::get('/about', [
            'uses' => 'Marketing\HomeController@about',
            'as' => 'about',
        ]);

        Route::get('/cities.json', [
            'uses' => 'Marketing\HomeController@cities',
            'as' => 'cities_json',
        ]);

        Route::get('/distances', [
            'uses' => 'Marketing\DistancesController@index',
            'as' => 'distances_index',
        ]);

        Route::get('/cities', [
            'uses' => 'Marketing\CitiesController@index',
            'as' => 'cities_index',
        ]);

        Route::get('/cities/{city}', [
            'uses' => 'Marketing\CitiesController@show',
            'as' => 'cities_show',
        ]);
    }
);

Route::get('admin/login', 'Admin\Auth\AuthController@showLoginForm');
Route::post('admin/login', 'Admin\Auth\AuthController@login');
Route::get('admin/logout', 'Admin\Auth\AuthController@logout');

Route::group(
    [
        'prefix' => 'admin',
        'middleware' => [ 'auth' ]
    ],
    function()
    {
        Route::get('/', function() {
            return redirect(route('dashboard'));
        });

        Route::get('/dashboard', [
            'uses' => 'Admin\DashboardController@index',
            'as' => 'dashboard',
        ]);

        Route::get('/users', [
            'uses' => 'Admin\Auth\AuthController@getList',
            'as' => 'users',
        ]);

        Route::get('/users/register', [
            'uses' => 'Admin\Auth\AuthController@getRegister',
            'as' => 'users.register',
        ]);

        Route::post('/users/register', [
            'uses' => 'Admin\Auth\AuthController@postRegister',
            'as' => 'users.register',
        ]);

        Route::get('/users/edit/{user}', [
            'uses' => 'Admin\Auth\AuthController@getEdit',
            'as' => 'users.edit',
        ]);

        Route::post('/users/edit/{user}', [
            'uses' => 'Admin\Auth\AuthController@postEdit',
            'as' => 'users.edit',
        ]);

        Route::get('/users/delete/{user}', [
            'uses' => 'Admin\Auth\AuthController@getDelete',
            'as' => 'users.delete',
        ]);

        Route::get('/pages/{page}', [
            'uses' => 'Admin\PagesController@index',
            'as' => 'pages.index',
        ]);

        Route::post('/pages/{page}', [
            'uses' => 'Admin\PagesController@save',
            'as' => 'pages.save',
        ]);
    }
);
