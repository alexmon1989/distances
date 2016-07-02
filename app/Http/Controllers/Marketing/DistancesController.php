<?php

namespace App\Http\Controllers\Marketing;

use App\City;
use App\Country;
use App\Events\DistancesRequestEvent;
use App\Http\Controllers\Controller;
use App\Route;
use cijic\phpMorphy\Facade\Morphy;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Orchestra\Support\Facades\Memory;
use Torann\GeoIP\GeoIPFacade;

class DistancesController extends Controller
{
    /**
     * Обработчик запроса с формы формирования маршрута.
     * По сути проверяет правильность ввода, создаёт в БД маршрут и переадресовывает на страницу маршрута.
     */
    public function index(Request $request)
    {
        // Коллекция городов, введенных пользователем (исключая пустые поля)
        $targetsCollection = collect($request->get('targets'))->reject(function ($name) {
            return empty($name);
        });

        // Валидация данных
        $v = Validator::make($request->all(), [
            'targets.*' => 'city_exists'
        ]);

        // Хук валидации для проверки количества заполненных полей (должно быть минимум 2 заполенных поля)
        $v->after(function($v) use ($targetsCollection) {
            if ($targetsCollection->count() < 2) {
                $v->errors()->add('targets', Lang::get('pages.index.targets_validation_error'));
            }
        });

        if ($v->fails()) {
            return redirect()
                ->route('index')
                ->withErrors($v)
                ->withInput();
        }

        // Редактируем коллекцию, заменяя названия городов на объекты Eloquent
        $targetsCollection = $targetsCollection->map(function($item, $key) {
            // Извлечение из строки города
            preg_match('/(.+) \(/', $item, $m);
            if (isset($m[1])) {
                $city = $m[1];
            }

            // Извлечение из строки страны
            preg_match('/\((.+)\)/', $item, $m);
            if (isset($m[1])) {
                $country = $m[1];
            }

            // Если пользователь ввёл в своём формате (только город, без страны), то получаем страну и город из google maps
            if (!isset($city) || !isset($country)) {
                $response = \GoogleMaps::load('geocoding')
                    ->setParam([
                        'address' => $item,
                        'language' => \App::getLocale(),
                    ])
                    ->get();
                $response = json_decode($response);
                $city = $response->results[0]->address_components[0]->long_name;
                // Элемент страны в массиве
                foreach ($response->results[0]->address_components as $value) {
                    if (in_array('country', $value->types)) {
                        $countryElem = $value;
                        break;
                    }
                }
                $country = $countryElem->long_name;
            }

            return City::whereTranslation('name', $city)
                ->whereHas('country', function($query) use ($country) {
                    $query->whereTranslation('name', $country);
                })
                ->first(['id', 'code']);
        });

        // Второй параметр роута, необходим для восприятия человеком ссылки
        $uriStr = '';
        foreach ($targetsCollection as $target) {
            $uriStr .= $uriStr ? '-' . $target->code : $target->code;
        }

        // Переадресация на страницу маршрута
        return redirect()->route(
            'distances.show_route', [
                'route' => Route::firstOrCreate([
                    'data_json' => $targetsCollection->toJson(),
                    'uri_str' => $uriStr,
                ]),
                'uri_str' => $uriStr,
            ]
        );
    }

    /**
     * Обработчик запроса на подсчёт стоимости поездки
     */
    public function calculateTravelCost(Request $request)
    {
        $distance = (int) $request->distance;

        // Получение топливных единиц для страны посетителя
        $location = GeoIPFacade::getLocation();
        $country = Country::whereCode($location['isoCode'])->first();
        if ($country) {
            $distanceUnit = $country->distance_unit;
            $volumeUnit =  $country->volume_unit;
            $fuelConsumption = $country->fuel_consumption;
            $fuelCost =  $country->fuel_cost;
            $currency =  $country->currency;
        } else {
            $distanceUnit =  Memory::get('DEFAULT_DISTANCE_UNIT', 'kilometer');
            $volumeUnit =  Memory::get('DEFAULT_VOLUME_UNIT', 'liter');
            $fuelConsumption = Memory::get('DEFAULT_FUEL_CONSUMPTION', 10);
            $fuelCost =  Memory::get('DEFAULT_FUEL_COST', 35);
            $currency =  Memory::get('DEFAULT_CURRENCY', 'ruble');
        }

        $totalDistance = $distanceUnit == 'kilometer' ? round($distance * 0.001) : round($distance * 0.000621371192);
        $fuelCount = round(($totalDistance / 100) * $fuelConsumption);
        $totalPrice = $fuelCount * $fuelCost;

        return [
            'total_distance' => $totalDistance . ' ' . Lang::get('pages.distances.' . $distanceUnit),
            'fuel_count' => $fuelCount . ' ' . Lang::get('pages.distances.' . $volumeUnit),
            'total_price' => $totalPrice . ' ' . Lang::get('pages.distances.' . $currency),
            'message' => Lang::get('pages.distances.total_price_message', [
              'fuel_consumption' => $fuelConsumption,
              'volume_unit' => Lang::get('pages.distances.' . $volumeUnit),
              'distance_unit' => Lang::get('pages.distances.' . $distanceUnit),
              'fuel_cost' => $fuelCost,
              'currency' => Lang::get('pages.distances.' . $currency)
            ])
        ];
    }

    /**
     * Показывает страницу маршрута.
     */
    public function showRoute(Route $route)
    {
        // Коллекция городов
        $targetsCollection = collect(json_decode($route->data_json));

        // Редактируем коллекцию, заменяя названия городов на объекты Eloquent
        $targetsCollection = $targetsCollection->map(function($item, $key) {
            return City::withTranslation()
                ->with(['country' => function($query) {
                    $query->withTranslation();
                }])
                ->find($item->id);
        });

        // Соединение с сервером погоды
        $owm = new OpenWeatherMap(Memory::get('OPENWEATHER_API_KEY', env('OPENWEATHER_API_KEY', 'b73effe13f365e1a8be704d86541fb21')));

        // Коллекция погод в пунктах
        $weathers = collect([]);
        if ($owm) {
            foreach ($targetsCollection as $target) {
                try {
                    $weather = $owm->getWeather($target->code . ', ' . $target->country->code, 'metric', \App::getLocale());
                } catch (\Exception $e) {
                    $weather = false;
                }

                // Город в предложном падеже
                if (\App::getLocale() == 'ru') {
                    try {
                        $cityName = Morphy::castFormByGramInfo(mb_strtoupper($target->name), null, ['ПР'], true)[0];
                        $cityName = mb_convert_case($cityName, MB_CASE_TITLE, 'utf-8');
                    } catch (\Exception $e) {
                        $cityName = $target->name;
                    }
                } else {
                    $cityName = $target->name;
                }
                $weathers->push([
                    'city_name' => $cityName,
                    'weather' => $weather
                ]);
            }
        }

        // Коллекция кодов промежуточных пунктов
        $wayPoints = $targetsCollection->slice(1, $targetsCollection->count() - 2);

        // Для блока "Расстояние между другими городами" (города для стартового города)
        $anotherCitiesFirst = City::withTranslation()
            ->where('code', '<>', $targetsCollection->first()->code)
            ->where('code', '<>', $targetsCollection->last()->code)
            ->whereIsOffer(true)
            ->whereIsEnabled(true)
            ->whereHas('country', function($query) use ($targetsCollection) {
                $query->whereCode($targetsCollection->first()->country->code);
            })
            ->with(['country' => function($query) {
                $query->withTranslation();
            }])
            ->take(15)
            ->get();

        // Для блока "Расстояние между другими городами" (города для финишного города)
        $anotherCitiesLast = City::withTranslation()
            ->where('code', '<>', $targetsCollection->first()->code)
            ->where('code', '<>', $targetsCollection->last()->code)
            ->whereIsOffer(true)
            ->whereIsEnabled(true)
            ->whereHas('country', function($query) use ($targetsCollection) {
                $query->whereCode($targetsCollection->last()->country->code);
            })
            ->with(['country' => function($query) {
                $query->withTranslation();
            }])
            ->take(15)
            ->get();

        // Стартовый город в родительном падеже
        if (App::getLocale() == 'ru') {
            try {
                $genitiveFromCity = Morphy::castFormByGramInfo(mb_strtoupper($targetsCollection->first()->name), null, ['ЕД', 'РД'], true)[0];
                $dativeToCity = Morphy::castFormByGramInfo(mb_strtoupper($targetsCollection->last()->name), null, ['ЕД', 'ВН'], true)[0];

                // Делаем заглавными только первые буквы
                $genitiveFromCity = mb_convert_case($genitiveFromCity, MB_CASE_TITLE, 'utf-8');
                $dativeToCity = mb_convert_case($dativeToCity, MB_CASE_TITLE, 'utf-8');
            } catch (\Exception $e) {
                $genitiveFromCity = $targetsCollection->first()->name;
                $dativeToCity = $targetsCollection->last()->name;
            }
        } else {
            $genitiveFromCity = $targetsCollection->first()->name;
            $dativeToCity = $targetsCollection->last()->name;
        }
        // Метатеги
        $pageTitle = str_replace([':city1', ':city2'],
            [$genitiveFromCity, $dativeToCity],
            Memory::get('DISTANCES_PAGE_TITLE_' . strtoupper(\App::getLocale())));
        $pageDescription = str_replace([':city1', ':city2'],
            [$genitiveFromCity, $dativeToCity],
            Memory::get('DISTANCES_PAGE_DESCRIPTION_' . strtoupper(\App::getLocale())));

        // Регистрация запроса в логах
        event(new DistancesRequestEvent($targetsCollection));

        // Отображение страницы
        return view(
            'marketing.distances.show',
            compact(
                'targetsCollection',
                'wayPoints',
                'anotherCitiesFirst',
                'anotherCitiesLast',
                'pageTitle',
                'pageDescription',
                'weathers'
            )
        );
    }
}
