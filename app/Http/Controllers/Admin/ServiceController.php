<?php

namespace App\Http\Controllers\Admin;

use App\City;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Orchestra\Support\Facades\Memory;

class ServiceController extends Controller
{
    /**
     * Отображает страницу настроек
     */
    public function index()
    {
        $lastClearDoubles = Memory::get('LAST_CLEAR_DOUBLES');

        return view('admin.service.index', compact('lastClearDoubles'));
    }

    /**
     * Обработчик запроса на очистку от дублей городов (только Россия)
     */
    public function clearDoubles() {
        $deleted = City::clearDoubles();

        $date = date('d.m.Y H:i:s');
        Memory::put('LAST_CLEAR_DOUBLES', $date);

        return [
            'status' => 'OK',
            'date' => $date,
            'deleted' => $deleted,
        ];
    }
}
