<?php

namespace App\Providers;

use App\City;
use Illuminate\Support\Facades\Validator;
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
        // Правило валидации, проверяющее существует ли город
        Validator::extend('city_exists', function($attribute, $value, $parameters, $validator) {
            $city = City::whereTranslation('name', $value)
                ->whereIsEnabled(true)
                ->first();
            return !empty($city);
        });

        Validator::replacer('city_exists', function($message, $attribute, $rule, $parameters) {
            preg_match('/\d/', $attribute, $matches);
            $cityField = str_replace($attribute, 'Пункт ' . ($matches[0] + 1), $attribute);
            return str_replace(':city_field', $cityField, $message);
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
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
            $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
        }
    }
}
