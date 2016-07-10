<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**
     * Очистка дублей городов (только Россия)
     */
    public static function clearDoubles()
    {
        // Делаем обычный прямой запрос для оптимизации
        $sql = '
            DELETE
            FROM
                cities
            WHERE
                cities.id NOT IN (
                    SELECT
                        q.id
                    FROM
                        (
                            SELECT
                                c.id
                            FROM
                                city_translations AS c_t
                            INNER JOIN cities AS c ON c.id = c_t.city_id
                            INNER JOIN countries AS co ON co.id = c.country_id
                            WHERE
                                co.`code` = \'ru\'
                            AND c_t.locale = \'ru\'
                            GROUP BY
                                c_t.`name`
                        ) AS q
                )
                AND cities.country_id IN (
                    SELECT
                        id
                    FROM
                        countries
                    WHERE
                        `code` = \'ru\'
                )
        ';

        $deleted = DB::delete($sql);

        return $deleted;
    }
}
