<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Hall;
use App\Models\Seance;
use App\Models\Seat;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $film = $request['film'] ?? Film::all()->first();
        $hall = $request['hall'] ?? Hall::all()->first();
        $dateChosen = $request['dateChosen'] ?? substr(Carbon::now(), 0, 10);
        $seance = $request['seance'] ?? Seance::all()->where('seance_start', Carbon::now())->first();
        $seatNull= ($seance == null) ? null : Seat::all()->where('seance_id', $seance['id'])->where('hall_id', $hall['id']);
        $seats = $request['seats'] ?? $seatNull;
        $selected = $request['selected'] ?? [];
        $count_ticket = $request['count'] ?? [];
        $qrCode = $request['qrCode'] ?? [];
        return view('user.ticket', [
            'qrCode'=> $qrCode,
            'count'=> $count_ticket,
            'selected'=> $selected,
            'film' => $film,
            'hall' => $hall,
            'seance'=> $seance,
            'dateChosen'=> $dateChosen,
            'seats'=> $seats,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Ticket $ticket)
    {
        $film = $request['film'] ?? Film::all()->first();
        $hall = $request['hall'] ?? Hall::all()->first();
        $selected = $request['selected'] ?? [];
        $countTicket = $request['count'] ?? [];
        $seance = $request['seance'] ?? Seance::all()->where('seance_start', Carbon::now())->first();
        $seatNull= ($seance == null) ? null : Seat::all()->where('seance_id', $seance['id'])->where('hall_id', $hall['id']);
        $seats = $request['seats'] ?? $seatNull;
        $dateChosen = $request['dateChosen'] ?? substr(Carbon::now(), 0, 10);

        $string = 'зал: '.$hall['name'].', фильм: '.$film['title'].', начало сеанса: '.substr($seance['seance_start'], -8, 5).', стоимость билета: '.$countTicket;
        foreach (json_decode($selected) as $item) {
            $int = (int)$hall['col'];
            $string .= ", ряд " . explode(',', $item)[0] . " место" . (explode(',', $item)[1] + (explode(',', $item)[0] - 1) * $int);
        }
        DB::table('tickets')->insert([
            'qr_code' => Hash::make($string),
            'film_id' => $film['id'],
            'count' => $request['count'],
            'seance_id' => $seance['id'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('user.ticket', [
            'qrCode'=> $string,
            'count'=> $countTicket,
            'selected'=> $selected,
            'film' => $film,
            'hall' => $hall,
            'seance'=> $seance,
            'dateChosen'=> $dateChosen,
            'seats'=> $seats,
        ]);

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
        //
    }
}
