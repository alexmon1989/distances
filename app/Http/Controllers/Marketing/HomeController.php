<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use cijic\phpMorphy\Facade\Morphy;
use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    /**
     * Показывает главную страницу
     *
     * @Get("/")
     */
    public function index()
    {
        //Morphy::castFormByGramInfo('МОСКВА', null, ['ЕД', 'РД'], true);

        return 'base route';
    }
}
