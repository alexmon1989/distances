<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Orchestra\Support\Facades\Memory;

class SettingsController extends Controller
{
    /**
     * Отображает страницу настроек
     */
    public function index()
    {
        // Получение настроек
        $settings = [
            'OPENWEATHER_API_KEY'           => Memory::get('OPENWEATHER_API_KEY', env('OPENWEATHER_API_KEY')),
            'GOOGLE_MAPS_API_KEY'           => Memory::get('GOOGLE_MAPS_API_KEY', env('GOOGLE_MAPS_API_KEY')),
            'DEFAULT_LANG'                  => Memory::get('DEFAULT_LANG', 'ru'),

            'DEFAULT_DISTANCE_UNIT'         => Memory::get('DEFAULT_DISTANCE_UNIT', 'kilometer'),
            'DEFAULT_VOLUME_UNIT'           => Memory::get('DEFAULT_VOLUME_UNIT', 'liter'),
            'DEFAULT_FUEL_CONSUMPTION'      => Memory::get('DEFAULT_FUEL_CONSUMPTION', 10),
            'DEFAULT_FUEL_COST'             => Memory::get('DEFAULT_FUEL_COST', 35),
            'DEFAULT_CURRENCY'              => Memory::get('DEFAULT_CURRENCY', 'ruble'),

            'DISTANCES_PAGE_TITLE_RU'       => Memory::get('DISTANCES_PAGE_TITLE_RU', ''),
            'DISTANCES_PAGE_DESCRIPTION_RU' => Memory::get('DISTANCES_PAGE_DESCRIPTION_RU', ''),
            'DISTANCES_PAGE_TEXT_RU'        => Memory::get('DISTANCES_PAGE_TEXT_RU', ''),
            'DISTANCES_PAGE_TITLE_EN'       => Memory::get('DISTANCES_PAGE_TITLE_EN', ''),
            'DISTANCES_PAGE_DESCRIPTION_EN' => Memory::get('DISTANCES_PAGE_DESCRIPTION_EN', ''),
            'DISTANCES_PAGE_TEXT_EN'        => Memory::get('DISTANCES_PAGE_TEXT_EN', ''),
            'DISTANCES_PAGE_TITLE_UK'       => Memory::get('DISTANCES_PAGE_TITLE_UK', ''),
            'DISTANCES_PAGE_DESCRIPTION_UK' => Memory::get('DISTANCES_PAGE_DESCRIPTION_UK', ''),
            'DISTANCES_PAGE_TEXT_UK'        => Memory::get('DISTANCES_PAGE_TEXT_UK', ''),
            'DISTANCES_PAGE_TITLE_PL'       => Memory::get('DISTANCES_PAGE_TITLE_PL', ''),
            'DISTANCES_PAGE_DESCRIPTION_PL' => Memory::get('DISTANCES_PAGE_DESCRIPTION_PL', ''),
            'DISTANCES_PAGE_TEXT_PL'        => Memory::get('DISTANCES_PAGE_TEXT_PL', ''),
            'DISTANCES_PAGE_TITLE_IT'       => Memory::get('DISTANCES_PAGE_TITLE_IT', ''),
            'DISTANCES_PAGE_DESCRIPTION_IT' => Memory::get('DISTANCES_PAGE_DESCRIPTION_IT', ''),
            'DISTANCES_PAGE_TEXT_IT'        => Memory::get('DISTANCES_PAGE_TEXT_IT', ''),
            'DISTANCES_PAGE_TITLE_FR'       => Memory::get('DISTANCES_PAGE_TITLE_FR', ''),
            'DISTANCES_PAGE_DESCRIPTION_FR' => Memory::get('DISTANCES_PAGE_DESCRIPTION_FR', ''),
            'DISTANCES_PAGE_TEXT_FR'        => Memory::get('DISTANCES_PAGE_TEXT_FR', ''),
            'DISTANCES_CITY1_CASE'          => Memory::get('DISTANCES_CITY1_CASE', ''),
            'DISTANCES_CITY2_CASE'          => Memory::get('DISTANCES_CITY2_CASE', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Обработчик запроса на сохранение
     */
    public function save(Request $request)
    {
        Memory::put('OPENWEATHER_API_KEY', $request->get('OPENWEATHER_API_KEY', Memory::get('OPENWEATHER_API_KEY')));
        Memory::put('GOOGLE_MAPS_API_KEY', $request->get('GOOGLE_MAPS_API_KEY', Memory::get('GOOGLE_MAPS_API_KEY')));
        Memory::put('DEFAULT_LANG', $request->get('DEFAULT_LANG', Memory::get('DEFAULT_LANG')));

        Memory::put('DEFAULT_DISTANCE_UNIT', $request->get('DEFAULT_DISTANCE_UNIT', Memory::get('DEFAULT_DISTANCE_UNIT')));
        Memory::put('DEFAULT_VOLUME_UNIT', $request->get('DEFAULT_VOLUME_UNIT', Memory::get('DEFAULT_VOLUME_UNIT')));
        Memory::put('DEFAULT_FUEL_CONSUMPTION', $request->get('DEFAULT_FUEL_CONSUMPTION', Memory::get('DEFAULT_FUEL_CONSUMPTION')));
        Memory::put('DEFAULT_FUEL_COST', $request->get('DEFAULT_FUEL_COST', Memory::get('DEFAULT_FUEL_COST')));
        Memory::put('DEFAULT_CURRENCY', $request->get('DEFAULT_CURRENCY', Memory::get('DEFAULT_CURRENCY')));

        foreach (['RU', 'EN', 'UK', 'IT', 'FR'] as $lang) {
            Memory::put('DISTANCES_PAGE_TITLE_'.$lang,
                $request->get('DISTANCES_PAGE_TITLE_'.$lang, Memory::get('DISTANCES_PAGE_TITLE_'.$lang)));
            Memory::put('DISTANCES_PAGE_DESCRIPTION_'.$lang,
                $request->get('DISTANCES_PAGE_DESCRIPTION_'.$lang, Memory::get('DISTANCES_PAGE_DESCRIPTION_'.$lang)));
            Memory::put('DISTANCES_PAGE_TEXT_'.$lang,
                $request->get('DISTANCES_PAGE_TEXT_'.$lang, Memory::get('DISTANCES_PAGE_TEXT_'.$lang)));
        }

        Memory::put('DISTANCES_CITY1_CASE', $request->get('DISTANCES_CITY1_CASE', Memory::get('DISTANCES_CITY1_CASE')));
        Memory::put('DISTANCES_CITY2_CASE', $request->get('DISTANCES_CITY2_CASE', Memory::get('DISTANCES_CITY2_CASE')));

        return redirect()->back()->with('success', 'Настройки успешно сохранены');
    }
}
