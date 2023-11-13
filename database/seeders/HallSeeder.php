<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seats =[];
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 12; $j++) {
                if(($i===1 && $j===1) || ($i===1 && $j===2) || ($i===1 && $j===5) || ($i===1 && $j===3) ) {
                    $seats["$i,$j"] = 'NORM';
                } elseif(($i===1 && $j===4) || ($i===1 && $j===6)) {
                    $seats["$i,$j"] = 'VIP';
                } else {
                    $seats["$i,$j"] = ['NORM','VIP', 'FAIL'][array_rand(['NORM','VIP', 'FAIL'])];
                }
                $seats2["$i,$j"] =['NORM','VIP', 'FAIL'][array_rand(['NORM','VIP', 'FAIL'])];
            }
        }
        $seats = json_encode($seats);
        $seats2 = json_encode($seats2);

        DB::table('halls')->insert([
            'name' => 'Зал 1',
            'col' => 12,
            'row' => 10,
            'count_vip' => 1000,
            'count_normal' => 500,
            'open'=> true,
            'seats_type' => $seats,

        ]);
        DB::table('halls')->insert([
            'name' => 'Зал 2',
            'col' => 12,
            'row' => 10,
            'count_vip' => 1000,
            'count_normal' => 500,
            'open'=> true,
            'seats_type' => $seats2,
        ]);
    }
}
