<?php

namespace App\Http\Controllers;


use App\Http\Requests\HallCreateRequest;
use App\Models\Film;
use App\Models\Hall;
use App\Models\Seance;
use App\Models\Seat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        dd($request);
        $halls = DB::table('halls')->get()->sortBy('name');
        $selected_hall = ($request->selected_hall) ?: $halls->first()->id;
        $selected_hall = (int)$selected_hall;
        return view('admin.index', ['halls' => $halls, 'selected_hall' => $selected_hall]);
    }

    /**
     * Show the form for creating a new resource.
     * @throws \Exception
     */
    public function create(Request $request)
    {

        $validated = validator($request->all(), [
            'name' => ['required', 'string', 'min:5'],
        ])->validate();

        $createHall = DB::table('halls', $request['name'])->where('name', $validated['name'])->get();

        if (count($createHall) !== 0) {
            return redirect()->back()->with('status','Ошибка зал с именем ' . $validated['name'] . ' уже существует');
        }
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
    public function edit(Request $request)
    {

        $id = $request->hall['id'];
        $json_seat = json_decode($request['json_seat']);
        $hallDb = DB::table('halls')
            ->where('id', $id)
            ->first();
        $seances = DB::table('seances')
            ->where('hall_id', $id)
            ->get();
//        dd($seances);
        if(count($seances) === 0){
            $hallTypeNew  = json_decode($request['newTypeHall']);
            $seatsType = $hallDb->seats_type = json_encode($hallTypeNew, JSON_THROW_ON_ERROR);
            DB::table('halls')
                ->where('id', $id)
                ->update([
                    'seats_type' => $seatsType,
                    'col' => $json_seat[0],
                    'row' => $json_seat[1],
                ]);

            return redirect()->back();

        }
        return redirect()->back()->with('status','Ошибка редактирования : В зале ' .$hallDb->name .' существуют сеансы');
    }

    public function editPriceHall(Request $request)
    {
//        dd($request);
        $id = $request->hall['id'];
        $json_price = json_decode($request['json_price']);
        DB::table('halls')
            ->where('id', $id)
            ->update([
                'count_vip' => $json_price[1],
                'count_normal' => $json_price[0],
            ]);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hall $hall)
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

    public function open($param)
    {
        $myArray = explode(',', $param);
        for ($i = 0; $i < count($myArray); $i++) {
            $elem = $myArray[$i];
            if($elem > 0){
                DB::table('halls')
                    ->where('id', $elem)
                    ->update([
                        'open' => true,
                    ]);
            }
        }
        return redirect()->back();
    }

    public function close($param)
    {
//        dd($param);
        $myArray = explode(',', $param);
        for ($i = 0; $i < count($myArray); $i++) {
            $elem = $myArray[$i];
            if($elem > 0){
                DB::table('halls')
                    ->where('id', $elem)
                    ->update([
                        'open' => false,
                    ]);
            }
        }
        return redirect()->back();
    }
}
