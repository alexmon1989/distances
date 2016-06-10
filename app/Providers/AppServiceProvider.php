<?php

namespace App\Providers;

use App\City;
use App\Country;
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
                $cityTitle = $m[1];
            }

            // Извлечение из строки страны
            preg_match('/\((.+)\)/', $value, $m);
            if (isset($m[1])) {
                $countryTitle = $m[1];
            }

            $city = false;
            // Если пользователь выбрал из списка город впредлагаемом формате "Город (Страна)"
            if (isset($countryTitle) && isset($cityTitle)) {
                $city = City::whereTranslation('name', $cityTitle)
                    ->whereIsEnabled(true)
                    ->whereHas('country', function ($query) use ($countryTitle) {
                        $query->whereIsEnabled(true)
                            ->whereTranslation('name', $countryTitle);
                    })
                    ->first();
            }

            // Если город был введён не в формате "Город (Страна)"
            if ($city == false) {
                // Ищем такой город в БД
                $city = City::whereTranslation('name', $value)
                    ->whereIsEnabled(true)
                    ->first();
            }

            // Если город и сейчас не найден, то произв. его поиск в google maps и добавл. в БД (если найден)
            if ($city == false) {
                $response = \GoogleMaps::load('geocoding')
                    ->setParam ([
                        'address' => $value,
                        'language' => \App::getLocale(),
                    ])
                    ->get();
                $response = json_decode($response);

                if ($response->status == 'OK') { // Город найден в google maps
                    // Код города
                    $cityCode = str_slug($response->results[0]->address_components[0]->short_name);

                    // Попытка найти в БД город по коду из google Maps
                    // (ситуация если пользователь ввёл город не так как он записан в БД, но в картах он нашелся)
                    $city = City::whereCode($cityCode)->first();

                    if ($city == false) {
                        // Элемент страны в массиве
                        foreach ($response->results[0]->address_components as $value) {
                            if (in_array('country', $value->types)) {
                                $countryElem = $value;
                                break;
                            }
                        }

                        if (!in_array('country', $countryElem->types)) {
                            // Если google не указывает страну, то считаем, что города нет
                            // (на момент разработки такая ситуация была по Крыму)
                            return false;
                        }

                        // Код страны
                        $countryCode = mb_strtolower($countryElem->short_name);

                        // Поиск страны в БД или её создание
                        $country = Country::whereCode($countryCode)->first();
                        if (!$country) {
                            // Создание страны
                            $country = Country::create([
                                'code' => $countryCode,
                                'is_enabled' => true,
                                'ru' => ['name' => $this->getObjectTitleFromGoogleMaps($countryElem->long_name, 'ru-RU')],
                                'en' => ['name' => $this->getObjectTitleFromGoogleMaps($countryElem->long_name, 'en-En')],
                                'uk' => ['name' => $this->getObjectTitleFromGoogleMaps($countryElem->long_name, 'uk-UA')],
                                'pl' => ['name' => $this->getObjectTitleFromGoogleMaps($countryElem->long_name, 'pl-PL')],
                            ]);
                        }

                        // Создание города
                        $cityTitle = $response->results[0]->address_components[0]->long_name;
                        $city = $country->cities()->create([
                            'code' => $cityCode,
                            'is_enabled' => true,
                            'is_offer' => true,
                            'ru' => ['name' => $this->getObjectTitleFromGoogleMaps($cityTitle, 'ru-RU')],
                            'en' => ['name' => $this->getObjectTitleFromGoogleMaps($cityTitle, 'en-En')],
                            'uk' => ['name' => $this->getObjectTitleFromGoogleMaps($cityTitle, 'uk-UA')],
                            'pl' => ['name' => $this->getObjectTitleFromGoogleMaps($cityTitle, 'pl-PL')],
                        ]);
                    }
                }
            }

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

    /**
     * Получение названия объекта (города, страны) на необходимом языке из Google Maps API
     */
    private function getObjectTitleFromGoogleMaps($countryTitle, $lang = 'ru-RU')
    {
        $response = \GoogleMaps::load('geocoding')
            ->setParam([
                'address' => $countryTitle,
                'language' => $lang,
            ])
            ->get('results.address_components');

        return $response['results'][0]['address_components'][0]['long_name'];
    }
}
