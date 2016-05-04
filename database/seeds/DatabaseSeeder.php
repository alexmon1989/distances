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

        Memory::put('site.welcome_article_ru', [
            'title' => 'Рассчитать расстояние между городами',
            'full_text' => '<p>Расчет расстояний между городами всех стран мира. Основной приоритет в нашей работе — актуальность информации и точность расчета расстояний. Наша карта автомобильных дорог помогает быстро определять расстояния между городами. Благодарим за интерес к нашему сервису, всегда рады быть полезными для Вас!</p>',
        ]);

        Memory::put('site.welcome_article_en', [
            'title' => 'Calculate the distance between cities',
            'full_text' => '<p>Calculation of distances between cities all over the world. The main priority of our work - the relevance of information and distance calculation accuracy. Our map of roads helps to quickly determine distances between cities. Thank you for your interest in our service, always happy to be of assistance to you!</p>',
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
