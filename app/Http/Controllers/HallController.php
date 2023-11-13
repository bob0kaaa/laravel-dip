<?php

namespace App\Http\Controllers;


use App\Models\Film;
use App\Models\Hall;
use App\Models\seance;
use App\Models\Seat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        dd(Auth::user()->admin);
    }

    /**
     * Show the form for creating a new resource.
     * @throws \Exception
     */
    public function create(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:6',
        ]);
         Hall::query()->create([
           'name' =>  $validated['name'],
        ]);

        return redirect()->route('admin.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return view('admin.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $film = $request->film ?? Film::all()->first();
        $hall = $request->hall ?? Hall::all()->first();
        $dateChosen = $request->dateChosen ?? substr(Carbon::now(), 0, 10);
        $seance = $request->seance ?? Seance::all()->where('seance_start', Carbon::now())->first();
        $seats = $request->seats ?? Seat::all()->where('seance_id', $seance['id'])->where('hall_id', $hall['id']);
        return view('user.hall', ['film' => $film, 'seats' => $seats, 'hall' => $hall, 'seance'=> $seance,  'dateChosen'=> $dateChosen]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Hall $hall)
    {
        $json_seat = json_decode($request['json_seat']);
        $hall1 = $request['hall'];
        $hall_new_decode = json_decode($request['newTypeOfSeats']);
        $hall_decode = json_decode($hall1['seats_type']);
        $i=0;

        $hall1['seats_type'] = json_encode($hall_decode, JSON_THROW_ON_ERROR);
       dd($hall_new_decode);

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
    public function delete(string $id)
    {
       $hall = Hall::find($id);
       $seance = DB::table('seances')->where('hall_id', $id)->first();
       if($seance == null){
           $hall->delete();
           return redirect()->route('admin.index');
       }
        return redirect()->back()->with('status','Ошибка удаления : В зале ' .$hall->name .' существуют сеансы');

    }
}
