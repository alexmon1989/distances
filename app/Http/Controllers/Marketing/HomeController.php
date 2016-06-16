<?php

namespace App\Http\Controllers\Marketing;

use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Orchestra\Support\Facades\Memory;

class HomeController extends Controller
{
    /**
     * Показывает главную страницу
     */
    public function index()
    {
        // Получение статьи с приветственным текстом
        $article = Memory::get('site.main_article_' . \App::getLocale());

        return view('marketing.home.index', compact('article'));
    }

    /**
     * Показывает страницу "Про сервис"
     */
    public function about()
    {
        // Получение статьи с приветственным текстом
        $article = Memory::get('site.about_article_' . \App::getLocale());

        return view('marketing.home.about', compact('article'));
    }

    /**
     * Возвращает json с городами
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cities(Request $request)
    {
        // Города
        $cities = City::whereTranslationLike('name', '%' . $request->q . '%')
            ->whereHas('country', function($query) {
                $query->whereIsEnabled(true);
            })
            ->with(['country' => function($query) {
                $query->withTranslation();
            }])
            ->get();

        // Создание коллекции названий городов для вывода
        $names = collect([]);
        foreach ($cities as $city) {
            $names->push([
                'name' => $city->name,
                'country' => $city->country->name,
            ]);
        }

        return $names->unique();
    }
}
