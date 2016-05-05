<?php

namespace App\Http\Controllers\Marketing;

use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use cijic\phpMorphy\Facade\Morphy;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Orchestra\Support\Facades\Memory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

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
            return City::whereTranslation('name', $item)->first();
        });

        // Коллекция кодов промежуточных пунктов
        $wayPoints = $targets->slice(1, $targets->count() - 2);

        // Для блока "Расстояние между другими городами"
        $anotherCities = City::withTranslation()
            ->whereHas('country', function($query) {
                $query->whereCode(\App::getLocale() == 'en' ? 'usa' : \App::getLocale());
            })
            ->where('code', '<>', $targets->first()->code)
            ->where('code', '<>', $targets->last()->code)
            ->whereIsOffer(true)
            ->whereIsEnabled(true)
            ->take(15)
            ->get();

        // Стартовый город в родительном падеже
        if (App::getLocale() == 'ru') {
            $genitiveFromCity = Morphy::castFormByGramInfo(mb_strtoupper($targets->first()->name), null, ['ЕД', 'РД'], true)[0];
            $dativeToCity = Morphy::castFormByGramInfo(mb_strtoupper($targets->last()->name), null, ['ЕД', 'ВН'], true)[0];
        } else {
            $genitiveFromCity = mb_strtoupper($targets->first()->name);
            $dativeToCity = mb_strtoupper($targets->last()->name);
        }

        // Отображение страницы
        return view(
            'marketing.distances.index',
            compact('targets', 'wayPoints', 'anotherCities', 'genitiveFromCity', 'dativeToCity')
        );
    }
}
