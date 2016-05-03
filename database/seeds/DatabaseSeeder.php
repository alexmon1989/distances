<?php

use Illuminate\Database\Seeder;
use Orchestra\Support\Facades\Memory;

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
        $this->call(CountriesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);

        Memory::put('site.about_article_ru', [
            'title' => 'Про сервис',
            'full_text' => 'Текст про сервис',
        ]);

        Memory::put('site.about_article_en', [
            'title' => 'About',
            'full_text' => 'About text',
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
