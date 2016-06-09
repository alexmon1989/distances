<?php

namespace App\Http\Controllers\Marketing;

use App\City;
use App\Country;
use App\Events\DistancesRequestEvent;
use App\Http\Controllers\Controller;
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
     * Показывает индексную страницу контроллера
     */
    public function index(Request $request)
    {
        // Валидация данных
        $v = Validator::make($request->all(), [
            'targets.*' => 'city_exists'
        ]);

        // Коллекция городов, введенных пользователем (исключая пустые поля)
        $targets = collect($request->get('targets'))->reject(function ($name) {
            return empty($name);
        });

        // Хук валидации для проверки количества заполненных полей (должно быть минимум 2 заполенных поля)
        $v->after(function($v) use ($targets) {
            if ($targets->count() < 2) {
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
        $targets = $targets->map(function($item, $key) {
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
                ->with(['country' => function($query) {
                    $query->withTranslation();
                }])
                ->first();
        });

        // Соединение с сервером погоды
        $owm = new OpenWeatherMap(Memory::get('OPENWEATHER_API_KEY', env('OPENWEATHER_API_KEY', 'b73effe13f365e1a8be704d86541fb21')));

        // Коллекция погод в пунктах
        $weathers = collect([]);
        if ($owm) {
            foreach ($targets as $target) {
                try {
                    $weather = $owm->getWeather($target->code . ', ' . $target->country->code, 'metric', \App::getLocale());
                } catch (\Exception $e) {
                    $weather = false;
                }

                // Город в предложном падеже
                if (\App::getLocale() == 'ru') {
                    $cityName = Morphy::castFormByGramInfo(mb_strtoupper($target->name), null, ['ЕД', 'ПР'], true)[0];
                    $cityName = mb_convert_case($cityName, MB_CASE_TITLE, 'utf-8');
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
        $wayPoints = $targets->slice(1, $targets->count() - 2);

        // Для блока "Расстояние между другими городами" (города для стартового города)
        $anotherCitiesFirst = City::withTranslation()
            ->where('code', '<>', $targets->first()->code)
            ->where('code', '<>', $targets->last()->code)
            ->whereIsOffer(true)
            ->whereIsEnabled(true)
            ->whereHas('country', function($query) use ($targets) {
                $query->whereCode($targets->first()->country->code);
            })
            ->with(['country' => function($query) {
                $query->withTranslation();
            }])
            ->take(15)
            ->get();

        // Для блока "Расстояние между другими городами" (города для финишного города)
        $anotherCitiesLast = City::withTranslation()
            ->where('code', '<>', $targets->first()->code)
            ->where('code', '<>', $targets->last()->code)
            ->whereIsOffer(true)
            ->whereIsEnabled(true)
            ->whereHas('country', function($query) use ($targets) {
                $query->whereCode($targets->last()->country->code);
            })
            ->with(['country' => function($query) {
                $query->withTranslation();
            }])
            ->take(15)
            ->get();

        // Стартовый город в родительном падеже
        if (App::getLocale() == 'ru') {
            $genitiveFromCity = Morphy::castFormByGramInfo(mb_strtoupper($targets->first()->name), null, ['ЕД', 'РД'], true)[0];
            $dativeToCity = Morphy::castFormByGramInfo(mb_strtoupper($targets->last()->name), null, ['ЕД', 'ВН'], true)[0];

            // Делаем заглавными только первые буквы
            $genitiveFromCity = mb_convert_case($genitiveFromCity, MB_CASE_TITLE, 'utf-8');
            $dativeToCity = mb_convert_case($dativeToCity, MB_CASE_TITLE, 'utf-8');
        } else {
            $genitiveFromCity = $targets->first()->name;
            $dativeToCity = $targets->last()->name;
        }

        // Регистрация запроса в логах
        event(new DistancesRequestEvent($targets));

        // Отображение страницы
        return view(
            'marketing.distances.index',
            compact(
                'targets',
                'wayPoints',
                'anotherCitiesFirst',
                'anotherCitiesLast',
                'genitiveFromCity',
                'dativeToCity',
                'weathers'
            )
        );
    }

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
}
