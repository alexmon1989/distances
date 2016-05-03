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
    }
);