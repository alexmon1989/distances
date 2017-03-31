<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'data_json', 'uri_str'
    ];

    /**
     * Создаёт или возвращает объект Route, созданный по 2-м городам
     *
     * @param \App\City $city1
     * @param \App\City $city2
     */
    public static function firstOrCreateByTwoCities(City $city1, City $city2) {
        $collection = collect([$city1->getArrayForRoute(), $city2->getArrayForRoute()]);

        return self::firstOrCreate([
            'data_json' => $collection->toJson(),
            'uri_str' => $city1->code . '-' . $city2->code,
        ]);
    }
}
