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
        switch (\App::getLocale()){
            case 'en':
                $countryCode = 'us';
                break;
            case 'uk':
                $countryCode = 'ua';
                break;
            default:
                $countryCode = \App::getLocale();
        }

        $country = Country::whereCode($countryCode)
            ->whereIsEnabled(true)
            ->first();

        $cities = City::whereCountryId($country->id)
            ->whereIsEnabled(true)
            ->withTranslation()
            ->orderBy('code')
            ->paginate(33);

        return view('marketing.cities.index', compact('country', 'cities'));
    }

    /**
     * Показывает страницу города
     */
    public function show(Country $country, City $city)
    {
        $anotherCities = City::withTranslation()
            ->whereHas('country', function($query) use ($country) {
                $query->whereCode($country->code);
            })
            ->where('code', '<>', $city->code)
            ->whereIsOffer(true)
            ->whereIsEnabled(true)
            ->get();

        return view('marketing.cities.show', compact('country', 'city', 'anotherCities'));
    }
}
