<?php

namespace App\Listeners;

use App\DistanceLog;
use App\Events\DistancesRequestEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DistancesRequestEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DistancesRequestEvent  $event
     * @return void
     */
    public function handle(DistancesRequestEvent $event)
    {
        // Формирование строки лога
        $arr = [];
        foreach($event->targets as $target) {
            $arr[] = $target->name;
        }
        $route = implode(' - ', $arr);

        // Запись лога запроса в БД
        $log = new DistanceLog();
        $log->route = $route;
        $log->save();
    }
}
