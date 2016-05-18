<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Config;
use Orchestra\Support\Facades\Memory;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        Config::set('googlemaps.key', Memory::get('GOOGLE_MAPS_API_KEY', env('GOOGLE_MAPS_API_KEY', 'AIzaSyC8Mxed4trkdkkJjucBbf376lMhYRxIVdE')));
    }
}
