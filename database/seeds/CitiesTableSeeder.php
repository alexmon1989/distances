<?php

use Illuminate\Database\Seeder;
use App\Country;
use App\City;
use App\CityTranslation;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::truncate();
        CityTranslation::truncate();

        $russia = Country::where('code', 'ru')->first();

        $moscowData = [
            'code' => 'moscow',
            'country_id' => $russia->id,
            'is_enabled' => true,
            'ru'  => ['name' => 'Москва'],
            'en'  => ['name' => 'Moscow'],
        ];
        $moscow = City::create($moscowData);

        $stPetersburgData = [
            'code' => 'st-petersburg',
            'country_id' => $russia->id,
            'is_enabled' => true,
            'ru'  => ['name' => 'Санкт-Петербург'],
            'en'  => ['name' => 'Saint-Petersburg'],
        ];
        $stPetersburg = City::create($stPetersburgData);

        $tulaData = [
            'code' => 'tula',
            'country_id' => $russia->id,
            'is_enabled' => true,
            'ru'  => ['name' => 'Тула'],
            'en'  => ['name' => 'Tula'],
        ];
        $tula = City::create($tulaData);

        $usa = Country::where('code', 'usa')->first();

        $washingtonData = [
            'code' => 'washington',
            'country_id' => $usa->id,
            'is_enabled' => true,
            'ru'  => ['name' => 'Вашингтон'],
            'en'  => ['name' => 'Washington'],
        ];
        $washington = City::create($washingtonData);

        $newYorkData = [
            'code' => 'new-york',
            'country_id' => $usa->id,
            'is_enabled' => true,
            'ru'  => ['name' => 'Нью-Йорк'],
            'en'  => ['name' => 'New York'],
        ];
        $newYork = City::create($newYorkData);

        $miamiData = [
            'code' => 'miami',
            'country_id' => $usa->id,
            'is_enabled' => true,
            'ru'  => ['name' => 'Маями'],
            'en'  => ['name' => 'Miami'],
        ];
        $miami = City::create($miamiData);

    }
}
