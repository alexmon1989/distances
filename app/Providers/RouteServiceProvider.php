<?php

namespace App\Providers;

use App\City;
use App\Country;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);

        // Роутинг по модели City для frontend
        if (\Request::segment(1) != 'admin') {
            $router->bind('city', function ($value) {
                return City::whereIsEnabled(true)
                    ->whereCode($value)
                    ->whereHas('country', function ($query) {
                        $query->whereIsEnabled(true);
                            //->whereCode(\App::getLocale() == 'en' ? 'usa' : \App::getLocale());
                    })
                    ->first();
            });

            $router->bind('country', function ($value) {
                return Country::whereIsEnabled(true)
                    ->whereCode($value)
                    ->first();
            });
        }
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
