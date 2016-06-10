<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Country;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    /**
     * Отображает страницу со списком городов определённой страны.
     */
    public function index(Country $country)
    {
        $cities = $country->cities()
            ->withTranslation()
            ->get();

        return view('admin.cities.index', compact('country', 'cities'));
    }

    /**
     * Отображает страницу создания города в определённой стране.
     */
    public function create(Country $country)
    {
        return view('admin.cities.create', compact('country'));
    }

    /**
     * Отображает страницу редактирования города.
     */
    public function edit(City $city)
    {
        $country = $city->country;

        return view('admin.cities.edit', compact('country', 'city'));
    }

    /**
     * Действие для создания или редактирования города.
     */
    public function createOrUpdate(Request $request, Country $country, City $city = null)
    {
        // Валидация данных
        $this->validate($request, [
            // TODO: не пропускать кириллицу в code
            'code' => 'required|alpha_dash|max:255|unique:cities,code' . ( $city->id ? ',' . $city->id : '' ),
            'name_ru' => 'required|max:255',
            'name_en' => 'required|max:255',
            'name_uk' => 'required|max:255',
            'name_pl' => 'required|max:255',
            'is_enabled' => 'boolean',
            'is_offer' => 'boolean',
        ]);

        if (!$city->id) {
            $city = new City();
            $data = [
                'code' => trim($request->code),
                'country_id' => $country->id,
                'is_enabled' => (bool) $request->is_enabled,
                'is_offer' => (bool) $request->is_offer,
                'ru'  => ['name' => trim($request->name_ru)],
                'en'  => ['name' => trim($request->name_en)],
                'uk'  => ['name' => trim($request->name_uk)],
                'pl'  => ['name' => trim($request->name_pl)],
            ];
            $city = City::create($data);

            $message = 'Город успешно создан.';
        } else {
            $city->code = trim($request->code);
            $city->country_id = $country->id;
            $city->translate('ru')->name = trim($request->name_ru);
            $city->translate('en')->name = trim($request->name_en);
            $city->translate('uk')->name = trim($request->name_uk);
            $city->translate('pl')->name = trim($request->name_pl);
            $city->is_enabled = (bool) $request->is_enabled;
            $city->is_offer = (bool) $request->is_offer;
            $city->save();

            $message = 'Город успешно отредактирован.';
        }

        return redirect()->route('cities.edit', ['city' => $city])->with('success', $message);
    }

    /**
     * Удаление города.
     */
    public function delete(City $city)
    {
        $city->delete();

        return redirect()->back()->with('success', 'Город успешно удалён.');
    }
}
