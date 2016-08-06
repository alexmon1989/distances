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

        //$i = 0;
        // Добавление переводов (итал., фр.) для существующих городов без переводов
        $notTranslatedCitiesIt = City::notTranslatedIn('it')
            ->with('country')
            ->get();
        foreach ($notTranslatedCitiesIt as $city) {
            sleep(1);
            $res = $this->getObjectTitleFromGoogleMaps($city->country->translate('ru')->name . ', ' . $city->translate('ru')->name, 'it');
            if ($res) {
                $city->translateOrNew('it')->name = $res;
                $city->save();
                //$i++;
                //echo $i . "\r\n";
            } else {
                $city->delete();
            }
        }
        $notTranslatedCitiesFr = City::notTranslatedIn('fr')
            ->with('country')
            ->get();
        foreach ($notTranslatedCitiesFr as $city) {
            sleep(1);
            $city->translateOrNew('fr')->name = $this->getObjectTitleFromGoogleMaps( $city->country->translate('ru')->name . ', ' . $city->translate('ru')->name, 'fr');
            $city->save();
            //$i++;
            //echo $i . "\r\n";
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
        if (isset($response['status']) && $response['status'] == 'ZERO_RESULTS') {
            return false;
        }
        if (!isset($response['results'][0]['address_components'][0]['long_name'])) {
            dd($response, $address);
        }

        return isset($response['results'][0]['address_components'][0]['long_name'])
            ? $response['results'][0]['address_components'][0]['long_name']
            : false;
    }
}
