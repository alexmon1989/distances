<?php

namespace App\Console;

use App\City;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Orchestra\Support\Facades\Memory;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Очистка от дублей городов
        $schedule->call(function() {
            City::clearDoubles();
            Memory::put('LAST_CLEAR_DOUBLES', date('d.m.Y H:i:s'));
        })->daily();

        // $schedule->command('inspire')
        //          ->hourly();
    }
}
