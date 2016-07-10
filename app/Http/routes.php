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
        'middleware' => ['defaultLanguage', 'localeSessionRedirect', 'localizationRedirect' ]
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

        Route::get('/distances/calculate-travel-cost', [
            'uses' => 'Marketing\DistancesController@calculateTravelCost',
            'as' => 'calculate_travel_cost',
        ]);

        Route::get('/distances/{route}-{uri_str}', [
            'uses' => 'Marketing\DistancesController@showRoute',
            'as' => 'distances.show_route',
        ]);

        Route::get('/cities', [
            'uses' => 'Marketing\CitiesController@index',
            'as' => 'cities_index',
        ]);

        Route::get('/cities/{country}/{city}', [
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

        Route::get('/countries', [
            'uses' => 'Admin\CountriesController@index',
            'as' => 'countries.index',
        ]);

        Route::get('/countries/create', [
            'uses' => 'Admin\CountriesController@create',
            'as' => 'countries.create',
        ]);

        Route::post('/countries/create', [
            'uses' => 'Admin\CountriesController@createOrUpdate',
            'as' => 'countries.create',
        ]);

        Route::get('/countries/edit/{country}', [
            'uses' => 'Admin\CountriesController@edit',
            'as' => 'countries.edit',
        ]);

        Route::post('/countries/edit/{country}', [
            'uses' => 'Admin\CountriesController@createOrUpdate',
            'as' => 'countries.edit',
        ]);

        Route::get('/countries/delete/{country}', [
            'uses' => 'Admin\CountriesController@delete',
            'as' => 'countries.delete',
        ]);

        Route::get('/cities/index/{country}', [
            'uses' => 'Admin\CitiesController@index',
            'as' => 'cities.index',
        ]);

        Route::get('/cities/create/{country}', [
            'uses' => 'Admin\CitiesController@create',
            'as' => 'cities.create',
        ]);

        Route::post('/cities/create/{country}', [
            'uses' => 'Admin\CitiesController@createOrUpdate',
            'as' => 'cities.create',
        ]);

        Route::get('/cities/edit/{city}', [
            'uses' => 'Admin\CitiesController@edit',
            'as' => 'cities.edit',
        ]);

        Route::post('/cities/edit/{country}/{city}', [
            'uses' => 'Admin\CitiesController@createOrUpdate',
            'as' => 'cities.postedit',
        ]);

        Route::get('/cities/delete/{city}', [
            'uses' => 'Admin\CitiesController@delete',
            'as' => 'cities.delete',
        ]);

        Route::get('/pages/{page}', [
            'uses' => 'Admin\PagesController@index',
            'as' => 'pages.index',
        ]);

        Route::post('/pages/{page}', [
            'uses' => 'Admin\PagesController@save',
            'as' => 'pages.save',
        ]);

        Route::get('/distance-logs/delete/{log}', [
            'uses' => 'Admin\DistanceLogsController@delete',
            'as' => 'distance-logs.delete',
        ]);

        Route::get('/distance-logs', [
            'uses' => 'Admin\DistanceLogsController@index',
            'as' => 'distance-logs.index',
        ]);

        Route::get('/settings', [
            'uses' => 'Admin\SettingsController@index',
            'as' => 'settings.index'
        ]);

        Route::post('/settings', [
            'uses' => 'Admin\SettingsController@save',
            'as' => 'settings.save'
        ]);

        Route::get('/service', [
            'uses' => 'Admin\ServiceController@index',
            'as' => 'service.index'
        ]);

        Route::post('/service/clear-doubles', [
            'uses' => 'Admin\ServiceController@clearDoubles',
            'as' => 'service.clear_doubles'
        ]);
    }
);
