<?php

namespace App\Providers;

use App\City;
use Illuminate\Support\Facades\Lang;
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
            // Извлечение из строки города
            preg_match('/(.+) \(/', $value, $m);
            if (isset($m[1])) {
                $city = $m[1];
            } else {
                return false;
            }

            // Извлечение из строки страны
            preg_match('/\((.+)\)/', $value, $m);
            if (isset($m[1])) {
                $country = $m[1];
            } else {
                return false;
            }

            $city = City::whereTranslation('name', $city)
                ->whereIsEnabled(true)
                ->whereHas('country', function($query) use ($country) {
                    $query->whereIsEnabled(true)
                        ->whereTranslation('name', $country);
                })
                ->first();

            return !empty($city);
        });

        Validator::replacer('city_exists', function($message, $attribute, $rule, $parameters) {
            preg_match('/\d/', $attribute, $matches);
            $cityField = str_replace($attribute, Lang::get('pages.index.item') . ' ' . ($matches[0] + 1), $attribute);
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
