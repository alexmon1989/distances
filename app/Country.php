<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = [
        'code',
        'name',
        'is_enabled',
        'distance_unit',
        'volume_unit',
        'fuel_consumption',
        'fuel_cost',
        'currency',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    // (optionaly)
    // protected $with = ['translations'];

    public function cities()
    {
        return $this->hasMany('App\City');
    }
}
