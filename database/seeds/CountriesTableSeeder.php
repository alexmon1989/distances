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
        ];
        $russia = Country::create($russiaData);

        $usaData = [
            'code' => 'usa',
            'is_enabled' => true,
            'ru'  => ['name' => 'Соединённые Штаты Америки'],
            'en'  => ['name' => 'United States of America'],
            'uk'  => ['name' => 'Сполучені Штати Америки'],
            'pl'  => ['name' => 'USA'],
        ];
        $usa = Country::create($usaData);

        $ukraineData = [
            'code' => 'ua',
            'is_enabled' => true,
            'ru'  => ['name' => 'Украина'],
            'en'  => ['name' => 'Ukraine'],
            'uk'  => ['name' => 'Україна'],
            'pl'  => ['name' => 'Ukraina'],
        ];
        $ukraine = Country::create($ukraineData);

        $polandData = [
            'code' => 'pl',
            'is_enabled' => true,
            'ru'  => ['name' => 'Польша'],
            'en'  => ['name' => 'Poland'],
            'uk'  => ['name' => 'Польща'],
            'pl'  => ['name' => 'Polska'],
        ];
        $poland = Country::create($polandData);
    }
}
