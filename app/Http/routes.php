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
    }
);
