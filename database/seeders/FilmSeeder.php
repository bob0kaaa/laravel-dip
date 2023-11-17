<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('films')->insert([
            'title' => 'Звёздные войны XXIII: Атака клонированных клонов',
            'description' => 'Две сотни лет назад малороссийские хутора разоряла шайка нехристей-ляхов во главе с могущественным колдуном.',
            'duration' => 130,
            'origin' => 'CША',
            'image_text' => 'Звёздные войны постер',
            'image_path' => 'upload/o39LIqqUuRCHss3PefRP6gEbW64i5nS9F7oynx24.png'
        ]);

        DB::table('films')->insert([
            'title' => 'Альфа',
            'description' => '20 тысяч лет назад Земля была холодным и неуютным местом, в котором смерть подстерегала человека на каждом шагу.',
            'duration' => 96,
            'origin' => 'Франция',
            'image_text' => 'Альфа постер',
            'image_path' => 'upload/TI2H5V1Th3oqX8KxIpun8QawgBJx7tCWEWNQIswg.jpg'
        ]);

        DB::table('films')->insert([
            'title' => 'Хищник',
            'description' => 'Самые опасные хищники Вселенной, прибыв из глубин космоса, высаживаются на улицах маленького городка, чтобы начать свою кровавую охоту. Генетически модернизировав себя с помощью ДНК других видов, охотники стали ещё сильнее, умнее и беспощаднее.',
            'duration' => 101,
            'origin' => 'Канада, CША',
            'image_text' => 'Хищник постер',
            'image_path' => 'upload/lAeXF50Y6yA0HS5NplyYdsdGN2nMeVQJHJK1PfMw.png'
        ]);
    }
}
