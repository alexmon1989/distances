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
        ];
        $russia = Country::create($russiaData);

        $usaData = [
            'code' => 'usa',
            'is_enabled' => true,
            'ru'  => ['name' => 'Соединённые Штаты Америки'],
            'en'  => ['name' => 'United States of America'],
        ];
        $usa = Country::create($usaData);
    }
}
