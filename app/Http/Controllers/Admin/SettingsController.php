<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Orchestra\Support\Facades\Memory;

class SettingsController extends Controller
{
    /**
     * Отображает страницу настроек
     */
    public function index()
    {
        // Получение настроек
        $settings = [
            'OPENWEATHER_API_KEY'   => Memory::get('OPENWEATHER_API_KEY', env('OPENWEATHER_API_KEY')),
            'GOOGLE_MAPS_API_KEY'   => Memory::get('GOOGLE_MAPS_API_KEY', env('GOOGLE_MAPS_API_KEY')),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Обработчик запроса на сохранение
     */
    public function save(Request $request)
    {
        Memory::put('OPENWEATHER_API_KEY', $request->OPENWEATHER_API_KEY);
        Memory::put('GOOGLE_MAPS_API_KEY', $request->GOOGLE_MAPS_API_KEY);

        return redirect()->back()->with('success', 'Настройки успешно сохранены');
    }
}
