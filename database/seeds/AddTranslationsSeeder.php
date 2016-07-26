<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\City;
use App\CityTranslation;

class AddTranslationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Добавление переводов (итал., фр.) для существующих стран без переводов
        $notTranslatedCountriesIt = Country::notTranslatedIn('it')->get();
        foreach ($notTranslatedCountriesIt as $country) {
            $country->translateOrNew('it')->name = $this->getObjectTitleFromGoogleMaps($country->name, 'it');
            $country->save();
        }
        $notTranslatedCountriesFr = Country::notTranslatedIn('fr')->get();
        foreach ($notTranslatedCountriesFr as $country) {
            $country->translateOrNew('fr')->name = $this->getObjectTitleFromGoogleMaps($country->name, 'fr');
            $country->save();
        }

        // Добавление переводов (итал., фр.) для существующих городов без переводов
        $notTranslatedCitiesIt = City::notTranslatedIn('it')
            ->with(['country' => function($query) {
                $query->withTranslation();
            }])
            ->get();
        foreach ($notTranslatedCitiesIt as $city) {
            $city->translateOrNew('it')->name = $this->getObjectTitleFromGoogleMaps( $city->country->name . ', ' . $city->name, 'it');
            $city->save();
        }
        $notTranslatedCitiesFr = City::notTranslatedIn('fr')
            ->with(['country' => function($query) {
                $query->withTranslation();
            }])
            ->get();
        foreach ($notTranslatedCitiesFr as $city) {
            $city->translateOrNew('fr')->name = $this->getObjectTitleFromGoogleMaps( $city->country->name . ', ' . $city->name, 'fr');
            $city->save();
        }
    }

    /**
     * Получение названия объекта (города, страны) на необходимом языке из Google Maps API
     */
    private function getObjectTitleFromGoogleMaps($address, $lang = 'ru-RU')
    {
        $response = \GoogleMaps::load('geocoding')
            ->setParam([
                'address' => $address,
                'language' => $lang,
            ])
            ->get('results.address_components');

        return $response['results'][0]['address_components'][0]['long_name'];
    }
}
