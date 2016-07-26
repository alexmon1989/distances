<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CountriesController extends Controller
{
    /**
     * Отображает страницу со списком стран
     */
    public function index()
    {
        $countries = Country::withTranslation()
            ->with('cities')
            ->get();

        return view('admin.countries.index', compact('countries'));
    }

    /**
     * Отображает страницу создания страны
     */
    public function create()
    {
        return view('admin.countries.create');
    }

    /**
     * Отображает страницу редактирования страны
     */
    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function createOrUpdate(Request $request, Country $country = null)
    {
        // Валидация данных
        $this->validate($request, [
            // TODO: не пропускать кириллицу в code
            'code' => 'required|alpha_dash|max:255|unique:countries,code' . ( $country->id ? ',' . $country->id : '' ),
            'name_ru' => 'required|max:255',
            'name_en' => 'required|max:255',
            'name_uk' => 'required|max:255',
            'name_pl' => 'required|max:255',
            'name_it' => 'required|max:255',
            'name_fr' => 'required|max:255',
            'distance_unit' => 'required|in:kilometer,mile',
            'volume_unit' => 'required|in:liter,us_gallon,imp_gallon',
            'fuel_consumption' => 'required|numeric',
            'fuel_cost' => 'required|numeric',
            'currency' => 'required|max:16',
            'is_enabled' => 'boolean',
        ]);

        if (!$country->id) {
            $data = [
                'code' => trim($request->code),
                'ru'  => ['name' => trim($request->name_ru)],
                'en'  => ['name' => trim($request->name_en)],
                'uk'  => ['name' => trim($request->name_uk)],
                'pl'  => ['name' => trim($request->name_pl)],
                'it'  => ['name' => trim($request->name_it)],
                'fr'  => ['name' => trim($request->name_fr)],
                'is_enabled' => (bool) $request->is_enabled,
                'distance_unit' => $request->distance_unit,
                'volume_unit' => $request->volume_unit,
                'fuel_consumption' => $request->fuel_consumption,
                'fuel_cost' => $request->fuel_cost,
                'currency' => trim($request->currency),
            ];
            $country = Country::create($data);

            $message = 'Страна успешно создана';
        } else {
            $country->code = trim($request->code);
            $country->translate('ru')->name = trim($request->name_ru);
            $country->translate('en')->name = trim($request->name_en);
            $country->translate('uk')->name = trim($request->name_uk);
            $country->translate('pl')->name = trim($request->name_pl);
            $country->translate('it')->name = trim($request->name_it);
            $country->translate('fr')->name = trim($request->name_fr);
            $country->is_enabled = (bool) $request->is_enabled;
            $country->distance_unit = $request->distance_unit;
            $country->volume_unit = $request->volume_unit;
            $country->fuel_consumption = $request->fuel_consumption;
            $country->fuel_cost = $request->fuel_cost;
            $country->currency = trim($request->currency);
            $country->save();

            $message = 'Страна успешно отредактирована';
        }

        return redirect()->route('countries.edit', ['country' => $country])->with('success', $message);
    }

    /**
     * Удаляет страну
     */
    public function delete(Country $country)
    {
        $country->delete();

        return redirect()->back()->with('success', 'Страна успешно удалена вместе с её городами');
    }
}
