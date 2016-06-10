<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Orchestra\Support\Facades\Memory;

class PagesController extends Controller
{
    protected $availablePages = ['main', 'about'];

    /**
     * Показывает индексную страницу
     */
    public function index($page)
    {
        // Проверка на корректность запроса редактируемой страницы
        if (!in_array($page, $this->availablePages)) {
            abort(404);
        }

        // Получение контента из БД
        $pageContent = [
            'article_ru' => Memory::get('site.'.$page.'_article_ru'),
            'article_en' => Memory::get('site.'.$page.'_article_en'),
            'article_uk' => Memory::get('site.'.$page.'_article_uk'),
            'article_pl' => Memory::get('site.'.$page.'_article_pl'),
        ];

        return view('admin.pages.index', compact('pageContent'));
    }

    /**
     * Обработчик изменнеия данных статьи
     */
    public function save(Request $request, $page)
    {
        // Проверка на корректность запроса редактируемой страницы
        if (!in_array($page, $this->availablePages)) {
            abort(404);
        }

        // Сохранение
        Memory::put('site.'.$page.'_article_ru', [
            'title' => $request->title_ru,
            'full_text' => $request->full_text_ru,
        ]);
        Memory::put('site.'.$page.'_article_en', [
            'title' => $request->title_en,
            'full_text' => $request->full_text_en,
        ]);
        Memory::put('site.'.$page.'_article_uk', [
            'title' => $request->title_uk,
            'full_text' => $request->full_text_uk,
        ]);
        Memory::put('site.'.$page.'_article_pl', [
            'title' => $request->title_pl,
            'full_text' => $request->full_text_pl,
        ]);

        return redirect()->back()->with('success', 'Страница успешно сохранена.');;
    }
}
