<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Hall;
use App\Models\Seance;
use App\Models\Seat;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SeatController extends Controller
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
    public function create(Request $request)
    {
        //
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
    public function edit(Request $request)
    {
//        dd($request->all());
        $film = $request['film'] ?? Film::all()->first();
        $hall = $request['hall'] ?? Hall::all()->first();
        $hall_decode = json_decode($hall['seats_type'], true);
        $dateChosen = $request['dateChosen'] ?? substr(Carbon::now(), 0, 10);
        $seance = $request['seance'] ?? Seance::all()->where('seance_start', Carbon::now())->first();
        $seatnull= ($seance == null) ? null : Seat::all()->where('seance_id', $seance['id'])->where('hall_id', $hall['id']);
        $seats = $request['seats'] ?? $seatnull;
        $selected = $request['selected'] ?? [];
        $seatts =[];
        for ($i = 0, $iMax = count(json_decode($selected)); $i < $iMax; $i ++) {
            $seatts[]= Seat::all()->where('seance_id', $seance['id'])->where('hall_id', $hall['id'])->where('row_number', (int) explode(',',  json_decode($selected)[$i])[0])->where('col_number', (int) explode(',', json_decode($selected)[$i])[1])->first();
        }
        $ticket= count(Ticket::all());
        $count_ticket = 0;
        for ($i = 0, $iMax = count($seatts); $i < $iMax; $i ++) {
            $seatts[$i]["free"]= "0";
            $seatts[$i]["ticket_id"]= (string) ($ticket+1);
            $ij = $seatts[$i]['row_number'].','.$seatts[$i]['col_number'];
            if($hall_decode[$ij]==='NORM') {
                $count_ticket += $hall['count_normal'];
            }
            if($hall_decode[$ij]==='VIP') {
                $count_ticket += $hall['count_vip'];
            }
            $seatts[$i]->save();
        }
        return redirect()->route('user.ticket.create',['count'=> $count_ticket,'selected'=> $selected, 'film' => $film, 'hall' => $hall, 'seance'=> $seance, 'dateChosen'=> $dateChosen, 'seats'=> $seats]);
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
    public function destroy(Request $request)
    {
        dd($request);
    }
}
