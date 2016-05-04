<?php

namespace App\Http\Controllers\Marketing;

use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class CitiesController extends Controller
{
    /**
     * Показывает страницу со списком городов
     */
    public function index()
    {
        $country = Country::whereCode(\App::getLocale() == 'en' ? 'usa' : \App::getLocale())
            ->whereIsEnabled(true)
            ->with(['cities' => function($query) {
                $query->whereIsEnabled(true)
                    ->withTranslation()
                    ->orderBy('code');
            }])
            ->first();

        return view('marketing.cities.index', compact('country'));
    }

    /**
     * Показывает страницу города
     */
    public function show(City $city)
    {
        $anotherCities = City::withTranslation()
            ->whereHas('country', function($query) {
                $query->whereCode(\App::getLocale() == 'en' ? 'usa' : \App::getLocale());
            })
            ->where('code', '<>', $city->code)
            ->whereIsOffer(true)
            ->whereIsEnabled(true)
            ->get();

        return view('marketing.cities.show', compact('city', 'anotherCities'));
    }
}
