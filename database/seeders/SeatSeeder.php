<?php

namespace Database\Seeders;

use App\Models\Seance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seances = Seance::all();
        foreach ($seances as $s) {
            for ($i = 1; $i <= 10; $i++) {
                for ($j = 1; $j <= 12; $j++) {
                    if(($s['id'] >= 1 && $s['id'] <=5) && (($i===1 && $j===1) || ($i===1 && $j===2) || ($i===1 && $j===4) || ($i===1 && $j===5) || ($i===1 && $j===3) || ($i===1 && $j===6))) {
                        $ticket_id = $j+$s['id']*5 ;
                        $free = false;
                    } else {
                        $ticket_id = 0;
                        $free = true;
                    }

                    DB::table('seats')->insert([
                        'hall_id' =>  $s['hall_id'],
                        'col_number' => $j,
                        'row_number' => $i,
                        'ticket_id' => $ticket_id,
                        'seance_id' => $s['id'],
                        'free' => $free,
                    ]);
                }
            }
        }
    }
}
