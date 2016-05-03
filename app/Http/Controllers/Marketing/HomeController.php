<?php

namespace App\Http\Controllers\Marketing;

use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use cijic\phpMorphy\Facade\Morphy;
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
        //Morphy::castFormByGramInfo('МОСКВА', null, ['ЕД', 'РД'], true);

        // Получение статьи с приветственным текстом
        $article = Memory::get('site.welcome_article_' . \App::getLocale());

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
    public function cities()
    {
        // Города
        $country = Country::whereCode(\App::getLocale() == 'en' ? 'usa' : \App::getLocale())
            ->whereIsEnabled(true)
            ->with(['cities' => function($query) {
                $query->whereIsEnabled(true)
                    ->orderBy('code');
            }])
            ->first();

        return $country->cities;
    }
}
