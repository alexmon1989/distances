<?php

use Illuminate\Database\Seeder;
use \Orchestra\Support\Facades\Memory;

class MemoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE TABLE orchestra_options;');
        Memory::put('site.about_article_ru', [
            'title' => 'Про сервис',
            'full_text' => 'Текст про сервис',
        ]);

        Memory::put('site.about_article_en', [
            'title' => 'About',
            'full_text' => 'About text',
        ]);

        Memory::put('site.about_article_uk', [
            'title' => 'Про сервіс',
            'full_text' => 'Текст про сервіс',
        ]);

        Memory::put('site.about_article_pl', [
            'title' => 'O obsługę',
            'full_text' => 'Tekst o obsługę',
        ]);

        Memory::put('site.main_article_ru', [
            'title' => 'Рассчитать расстояние между городами',
            'full_text' => '<p>Расчет расстояний между городами всех стран мира. Основной приоритет в нашей работе — актуальность информации и точность расчета расстояний. Наша карта автомобильных дорог помогает быстро определять расстояния между городами. Благодарим за интерес к нашему сервису, всегда рады быть полезными для Вас!</p>',
        ]);

        Memory::put('site.main_article_en', [
            'title' => 'Calculate the distance between cities',
            'full_text' => '<p>Calculation of distances between cities all over the world. The main priority of our work - the relevance of information and distance calculation accuracy. Our map of roads helps to quickly determine distances between cities. Thank you for your interest in our service, always happy to be of assistance to you!</p>',
        ]);

        Memory::put('site.main_article_uk', [
            'title' => 'Розрахувати відстань між містами',
            'full_text' => '<p>Розрахунок відстаней між містами всіх країн світу. Основний пріоритет у нашій роботі - актуальність інформації та точність розрахунку відстаней. Наша карта автомобільних доріг допомагає швидко визначати відстані між містами. Дякуємо за інтерес до нашого сервісу, завжди раді бути корисними для Вас!</p>',
        ]);

        Memory::put('site.main_article_pl', [
            'title' => 'Oblicz odległość między miastami',
            'full_text' => '<p>Obliczanie odległości między miastami na całym świecie. Głównym priorytetem naszej pracy - znaczenie dokładności informacji i odległości obliczeniowej. Nasza mapa dróg pomaga szybko ustalić odległości między miastami. Dziękujemy za zainteresowanie naszą służbę, zawsze gotowi do pomocy ty!</p>',
        ]);
    }
}
