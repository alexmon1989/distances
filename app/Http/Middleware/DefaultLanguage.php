<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Orchestra\Support\Facades\Memory;
use Torann\GeoIP\GeoIPFacade;

class DefaultLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Локаль (язык) по умолчанию
        if (!Session::get('lang')) {
            $isLangSet = false;
            $location = GeoIPFacade::getLocation();
            if (!$location['default']) {
                $isoCode = mb_strtolower($location['isoCode']);
                foreach (Config::get('locales') as $key => $value) {
                    if (in_array($isoCode, $value)) {
                        LaravelLocalization::setLocale($key);
                        Session::set('lang', \App::getLocale()); // Показатель того, что пользователь заходил на сайт
                        $isLangSet = true;
                        break;
                    }
                }
            }
            if (!$isLangSet) {
                $defaultLang = Memory::get('DEFAULT_LANG', 'ru');
                LaravelLocalization::setLocale($defaultLang);
                Session::set('lang', $defaultLang);
            }
        }

        return $next($request);
    }
}
