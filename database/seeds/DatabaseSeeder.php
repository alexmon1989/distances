<?php

use Illuminate\Database\Seeder;
use Orchestra\Support\Facades\Memory;
use \App\DistanceLog;
use \App\Route;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // $this->call(UsersTableSeeder::class);
        //$this->call(CountriesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        //$this->call(MemoryTableSeeder::class);

        //DistanceLog::truncate();
        //Route::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
