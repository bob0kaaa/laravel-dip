<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeanceCreateRequest;
use App\Models\Film;
use App\Models\Seance;
use App\Models\Seat;
use App\Models\Ticket;
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
    public function create(Request $request)
    {
//        dd($request);
//        $data = explode(" ", Carbon::now());
//        $data[1]=$request['seance_start'];
//        $data = implode(" ", $data);
        Seance::query()->create([
            'hall_id' => $request->all()['hall_id'],
            'film_id' => $request->all()['film_id'],
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
            'seance_start' => $request['seance_start'],
        ]);
        return redirect()->back();
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

        $tickets = DB::table('tickets')
            ->where('seance_id', $id)
            ->first();

        if ($tickets !== null) {
             return redirect()->back()->with('status','Ошибка удаления : на сеанс забронированы билеты');
        }
        Seance::find($id)->delete();
        return redirect()->back();
    }
}
