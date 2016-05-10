<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['code', 'name', 'country_id', 'is_enabled', 'is_offer'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        if (\Request::segment(1) != 'admin') {
            return 'code';
        }
        return 'id';
    }

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    // (optionaly)
    // protected $with = ['translations'];

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

}
