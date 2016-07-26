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
            'is_offer' => true,
            'ru'  => ['name' => 'Москва'],
            'en'  => ['name' => 'Moscow'],
            'uk'  => ['name' => 'Москва'],
            'pl'  => ['name' => 'Moskwa'],
            'it'  => ['name' => 'Mosca'],
            'fr'  => ['name' => 'Moscou'],
        ];
        $moscow = City::create($moscowData);

        $stPetersburgData = [
            'code' => 'st-petersburg',
            'country_id' => $russia->id,
            'is_enabled' => true,
            'is_offer' => true,
            'ru'  => ['name' => 'Санкт-Петербург'],
            'en'  => ['name' => 'Saint-Petersburg'],
            'uk'  => ['name' => 'Санкт-Петербург'],
            'pl'  => ['name' => 'Petersburg'],
            'it'  => ['name' => 'San Pietroburgo'],
            'fr'  => ['name' => 'Saint-Pétersbourg'],
        ];
        $stPetersburg = City::create($stPetersburgData);

        $tulaData = [
            'code' => 'tula',
            'country_id' => $russia->id,
            'is_enabled' => true,
            'is_offer' => true,
            'ru'  => ['name' => 'Тула'],
            'en'  => ['name' => 'Tula'],
            'uk'  => ['name' => 'Тула'],
            'pl'  => ['name' => 'Tuła'],
            'it'  => ['name' => 'Tula'],
            'fr'  => ['name' => 'Tula'],
        ];
        $tula = City::create($tulaData);

        $usa = Country::where('code', 'us')->first();

        $washingtonData = [
            'code' => 'washington',
            'country_id' => $usa->id,
            'is_enabled' => true,
            'is_offer' => true,
            'ru'  => ['name' => 'Вашингтон'],
            'en'  => ['name' => 'Washington'],
            'uk'  => ['name' => 'Вашингтон'],
            'pl'  => ['name' => 'Waszyngton'],
            'it'  => ['name' => 'Washington'],
            'fr'  => ['name' => 'Washington'],
        ];
        $washington = City::create($washingtonData);

        $newYorkData = [
            'code' => 'new-york',
            'country_id' => $usa->id,
            'is_enabled' => true,
            'is_offer' => true,
            'ru'  => ['name' => 'Нью-Йорк'],
            'en'  => ['name' => 'New York'],
            'uk'  => ['name' => 'Нью-Йорк'],
            'pl'  => ['name' => 'NY'],
            'it'  => ['name' => 'NY'],
            'fr'  => ['name' => 'New York'],
        ];
        $newYork = City::create($newYorkData);

        $chicagoData = [
            'code' => 'chicago',
            'country_id' => $usa->id,
            'is_enabled' => true,
            'is_offer' => true,
            'ru'  => ['name' => 'Чикаго'],
            'en'  => ['name' => 'Chicago'],
            'uk'  => ['name' => 'Чикаго'],
            'pl'  => ['name' => 'Chicago'],
            'it'  => ['name' => 'Chicago'],
            'fr'  => ['name' => 'Chicago'],
        ];
        $chicago = City::create($chicagoData);
    }
}
