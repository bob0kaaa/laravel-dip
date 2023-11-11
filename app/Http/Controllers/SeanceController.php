<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Seat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $open= $request->open ?? 0;
        $selected_hall= $request->hall->{'id'} ?? '1';
        $seance_id_last= Seance::all()->last()->id;
        $data = explode(" ", Carbon::now());
        $data[1]=$request['start_seance'];
        $data = implode(" ", $data);
        DB::table('seances')->insert([
            'film_id' => $request['film_id'],
            'hall_id' => $request['hall_id'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'startSeance'=> $data,
        ]);
        $seance =  Seance::all()->last();
        $hall = Hall::all()->where('id', $seance['hall_id'])->first();

        for ($i = 1; $i <= $hall['row']; $i++) {
            for ($j = 1; $j <= $hall['col']; $j++) {
                $seat = new Seat();
                $seat->hall_id = $seance['hall_id'];
                $seat->colNumber = $j;
                $seat->rowNumber = $i;
                $seat->ticket_id = 0;
                $seat->seance_id = $seance['id'];
                $seat->free = true;

                $seance->seats()->save($seat);
            }
        }
        if($request['confStep']) {
            $confStep = $request['confStep'];
        } else {
            $confStep = ['conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_opened', 'conf-step__header_closed'];
        }

        for ($dn = 1; $dn <= 13; $dn++) {
            $data = explode(" ", Carbon::now()->addDays($dn));
            $data[1] = $request['start_seance'];
            $data = implode(" ", $data);

            DB::table('seances')->insert([
                'film_id' => $request['film_id'],// не нужно, опрределяем через seance
                'hall_id' => $request['hall_id'],
                'created_at' => Carbon::now()->addMinute(), //date("Y-m-d H:i:s"),//Carbon::now()
                'updated_at' => Carbon::now()->addMinute(),//date("Y-m-d H:i:s"),//Carbon::now()
                'seance_start' => $data,
            ]);

            $seance = Seance::all()->last();
            $hall = $seance->hall;
            for ($ii = 1; $ii <= $hall['row']; $ii++) {
                for ($jj = 1; $jj <= $hall['col']; $jj++) {
                    $seat = new Seat();
                    $seat->hall_id = $seance['hall_id'];
                    $seat->col_number = $jj;// $seat->colNumber= Hall::all()->where('id', $seance['hall_id'])->col;
                    $seat->row_number = $ii; //Hall::all()->where('id', $seance['hall_id'])->row;
                    $seat->ticket_id = 0;
                    $seat->seance_id = $seance['id'];//Seance::all()->last()->id;
                    $seat->free = true;
                    $seance->seats()->save($seat);
                }
            }
        }
        return redirect()->route('admin.index', ['confStep'=> $confStep, 'open'=> $open, 'selected_hall' => $selected_hall]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $seance = Seance::find($id);
        $unique = Seance::all()->where('film_id', $seance['film_id'])->where('hall_id', $seance['hall_id'])->values();
        $unique2= Seance::all()->where('film_id', $seance['film_id'])->where('hall_id', $seance['hall_id'])->unique(function ($item, $key) {
            return substr($item['startSeance'], -8, 5);
        });// все уникальные сеансы в зале с выбранным фильмом
        $r = Seance::all()->where('film_id', $seance['film_id'])->where('hall_id', $seance['hall_id'])->pluck('startSeance');
        $ss=[];//
        for($i=0; $i<count($r); $i++){
            if (substr($r[$i], -8,5) == substr($seance['startSeance'], -8,5)){
                array_push($ss,$unique[$i] );
            }
        }
        foreach($ss as $seance) {
            $seance->seats()->delete();
            $seance->tickets()->delete();
            $seance->delete();
        }

        return redirect()->route('admin.home');
    }
}
