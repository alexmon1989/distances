<?php

namespace App\Http\Controllers\Marketing;

use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use cijic\phpMorphy\Facade\Morphy;
use Illuminate\Http\Request;

use App\Http\Requests;
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

        $targetsArr = [];

        $v->after(function($v) use ($request, &$targetsArr)
        {
            // Собираем новый массив с введенными городами
            if ($request->get('targets')) {
                for ($i = 0; $i < count($request->targets); $i++) {
                    if (trim($request->targets[$i]) != '') {
                        $targetsArr[] = $request->targets[$i];
                    }
                }
            }

            if (count($targetsArr) < 2) {
                $v->errors()->add('targets', Lang::get('pages.index.targets_validation_error'));
            }
        });

        if ($v->fails())
        {
            return redirect()
                ->route('index')
                ->withErrors($v)
                ->withInput();
        }

        // Первый и последний пункты назначения
        $fromCode = City::whereTranslation('name', $targetsArr[0])->first()->code;
        $toCode = City::whereTranslation('name', $targetsArr[count($targetsArr) - 1])->first()->code;

        // Промежуточные пункты
        $wayPoints = [];
        for ($i = 1; $i < count($targetsArr) - 1; $i++) {
            $wayPoints[] = City::whereTranslation('name', $targetsArr[$i])->first()->code;
        }

        // Для блока "Расстояние между другими городами"
        $anotherCities = City::withTranslation()
            ->whereHas('country', function($query) {
                $query->whereCode(\App::getLocale() == 'en' ? 'usa' : \App::getLocale());
            })
            ->where('code', '<>', $fromCode)
            ->where('code', '<>', $toCode)
            ->whereIsOffer(true)
            ->whereIsEnabled(true)
            ->take(15)
            ->get();

        // Отображение страницы
        return view(
            'marketing.distances.index',
            compact('targetsArr', 'fromCode', 'toCode', 'wayPoints', 'anotherCities')
        );
    }
}
