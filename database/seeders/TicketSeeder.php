<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tickets')->insert([
            'qr_code' => Hash::make('Фильм : Атака, сеанс 1, ряд 1, место 6, стоимость 1000'),
            'seance_id' => 1,
            'film_id' => 1,
            'count' => 1000,
        ]);

        DB::table('tickets')->insert([
            'qr_code' => Hash::make('Фильм : 2, сеанс 1, ряд 1, место 5, стоимость 500'),
            'seance_id' => 1,
            'film_id' => 1,
            'count' => 500,
        ]);

        DB::table('tickets')->insert([
            'qr_code' => Hash::make('Фильм : 2, сеанс 1, ряд 1, место 3, ряд 1, место 4,стоимость 1500'),
            'seance_id' => 1,
            'film_id' => 1,
            'count' => 1500,
        ]);

        DB::table('tickets')->insert([
            'qr_code' => Hash::make('Фильм : Атака, сеанс 3, ряд 1, место 2, стоимость 500'),
            'seance_id' => 1,
            'film_id' => 1,
            'count' => 500,
        ]);

        DB::table('tickets')->insert([
            'qr_code' => Hash::make('Фильм : Атака, сеанс 2, ряд 1, место 1, стоимость 500'),
            'seance_id' => 1,
            'film_id' => 1,
            'count' => 500,
        ]);
    }
}
