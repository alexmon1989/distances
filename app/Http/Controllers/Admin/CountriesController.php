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
            'is_enabled' => 'boolean',
        ]);

        if (!$country->id) {
            $data = [
                'code' => trim($request->code),
                'ru'  => ['name' => trim($request->name_ru)],
                'en'  => ['name' => trim($request->name_en)],
                'is_enabled' => $request->is_enabled,
            ];
            $country = Country::create($data);

            $message = 'Страна успешно создана';
        } else {
            $country->code = trim($request->code);
            $country->translate('ru')->name = trim($request->name_ru);
            $country->translate('en')->name = trim($request->name_en);
            $country->is_enabled = $request->is_enabled;
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
