<?php

use Illuminate\Database\Seeder;
use \App\Country;
use App\CountryTranslation;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();
        CountryTranslation::truncate();

        $russiaData = [
            'code' => 'ru',
            'is_enabled' => true,
            'ru'  => ['name' => 'Россия'],
            'en'  => ['name' => 'Russia'],
            'uk'  => ['name' => 'Росія'],
            'pl'  => ['name' => 'Rosja'],
            'distance_unit' => 'kilometer',
            'volume_unit' => 'liter',
            'fuel_consumption' => 10,
            'fuel_cost' => 35,
            'currency' => 'ruble',
        ];
        $russia = Country::create($russiaData);

        $usaData = [
            'code' => 'us',
            'is_enabled' => true,
            'ru'  => ['name' => 'Соединённые Штаты Америки'],
            'en'  => ['name' => 'United States of America'],
            'uk'  => ['name' => 'Сполучені Штати Америки'],
            'pl'  => ['name' => 'USA'],
            'distance_unit' => 'mile',
            'volume_unit' => 'us_gallon',
            'fuel_consumption' => 5,
            'fuel_cost' => 2,
            'currency' => 'us_dollar',
        ];
        $usa = Country::create($usaData);

        $ukraineData = [
            'code' => 'ua',
            'is_enabled' => true,
            'ru'  => ['name' => 'Украина'],
            'en'  => ['name' => 'Ukraine'],
            'uk'  => ['name' => 'Україна'],
            'pl'  => ['name' => 'Ukraina'],
            'distance_unit' => 'kilometer',
            'volume_unit' => 'liter',
            'fuel_consumption' => 10,
            'fuel_cost' => 22,
            'currency' => 'uah',
        ];
        $ukraine = Country::create($ukraineData);

        $polandData = [
            'code' => 'pl',
            'is_enabled' => true,
            'ru'  => ['name' => 'Польша'],
            'en'  => ['name' => 'Poland'],
            'uk'  => ['name' => 'Польща'],
            'pl'  => ['name' => 'Polska'],
            'distance_unit' => 'kilometer',
            'volume_unit' => 'liter',
            'fuel_consumption' => 10,
            'fuel_cost' => 1.5,
            'currency' => 'euro',
        ];
        $poland = Country::create($polandData);
    }
}
