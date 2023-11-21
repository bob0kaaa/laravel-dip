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

        $data = explode(" ", Carbon::now());
        $data[1]=$request['seance_start'];
        $data = implode(" ", $data);
        Seance::query()->create([
            'hall_id' => $request->all()['hall_id'],
            'film_id' => $request->all()['film_id'],
            'seance_start' => $data,
        ]);
        $seance = DB::table('seances')
            ->where('hall_id', $request->all()['hall_id'])
            ->where('film_id', $request->all()['film_id'])
            ->where('seance_start', $data)->get();
//        dd();
        $hall = DB::table('halls')
            ->where('id', $request->all()['hall_id'])->get();
        $anObject = json_decode($hall[0]->seats_type);
        $keysFromObject = array_keys(get_object_vars($anObject));
        for ($i = 0; $i < count($keysFromObject); $i++) {
            $elem = $keysFromObject[$i];
            $myArray = explode(',', $elem);
            $row = $myArray[0];
            $col = $myArray[1];
            $keyCuston = $row . ',' . $col;
            foreach ($anObject as $key => $val) {
                if ($keyCuston === $key) {
                    Seat::query()->create([
                        'free' => true,
                        'col_number' => $col,
                        'row_number' => $row,
                        'hall_id' => $request->all()['hall_id'],
                        'ticket_id' => 0,
                        'seance_id' => $seance[0]->id,
                    ]);
                }
            }
        }

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
