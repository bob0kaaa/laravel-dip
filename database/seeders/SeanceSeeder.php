<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seances')->insert([
            'seance_start' => Carbon::now(),
            'film_id' => 1,
            'hall_id' => 1,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addDays(2),
            'film_id' => 1,
            'hall_id' => 1,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(330),
            'film_id' => 1,
            'hall_id' => 1,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(660),
            'film_id' => 1,
            'hall_id' => 1,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(50),//'seance_start' => Carbon::now()->addMinutes(210),
            'film_id' => 1,
            'hall_id' => 2,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(280),//'seance_start' => Carbon::now()->addMinutes(420),
            'film_id' => 1,
            'hall_id' => 2,
        ]);


        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(510),
            'film_id' => 1,
            'hall_id' => 2,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(740),
            'film_id' => 1,
            'hall_id' => 2,
        ]);


        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(970),
            'film_id' => 1,
            'hall_id' => 2,
        ]);


        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(1200),
            'film_id' => 1,
            'hall_id' => 2,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(130),
            'film_id' => 2,
            'hall_id' => 1,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(130+330),
            'film_id' => 2,
            'hall_id' => 1,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(130+660),
            'film_id' => 2,
            'hall_id' => 1,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(50+130),
            'film_id' => 2,
            'hall_id' => 2,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(50+130+230),
            'film_id' => 2,
            'hall_id' => 2,
        ]);


        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(50+130+460),
            'film_id' => 2,
            'hall_id' => 2,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(50+130+690),
            'film_id' => 2,
            'hall_id' => 2,
        ]);


        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(50+130+920),
            'film_id' => 2,
            'hall_id' => 2,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(230),
            'film_id' => 3,
            'hall_id' => 1,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(230+330),
            'film_id' => 3,
            'hall_id' => 1,
        ]);

        DB::table('seances')->insert([
            'seance_start' => Carbon::now()->addMinutes(230+660),
            'film_id' => 3,
            'hall_id' => 1,
        ]);
    }
}
