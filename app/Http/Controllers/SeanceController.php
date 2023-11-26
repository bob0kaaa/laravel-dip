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
        $freeTime = true;
        $date = $request->all()['seance_date'];
        $time = $request->all()['seance_start'];
        $seanceStart = $date . ' ' . $time;
        $seanceStart = Carbon::parse($seanceStart);

        $seance = DB::table('seances')
            ->where('seance_start', '<=', $seanceStart)
            ->where('hall_id', $request->all()['hall_id'])
            ->latest('updated_at')->first();
//        dd($seance->film_id);
        $film = DB::table('films')
            ->where('id', $seance->film_id)->first();
        $seanceStartFilm =  Carbon::parse($seance->seance_start);
        $seanceStartFilmTwo =  Carbon::parse($seance->seance_start);

        $durationFilm = (int)$film->duration / 60;
        $timeHours = (int)floor($durationFilm);
        $timeMinutes =  (int)$film->duration - ((int)floor($durationFilm) * 60 );
        $seanceFinishFilm = Carbon::parse($seance->seance_start)->addHour($timeHours)->addMinute($timeMinutes);
        $seanceFinishFilmTwo = $seanceStartFilmTwo->addHour($timeHours)->addMinute($timeMinutes);
        $comingSoon = $seanceFinishFilmTwo->addMinute(10);
//                dd($seanceStart);
//                dd($seanceStartFilm);
//                dd($seanceFinishFilm);
//        dd($comingSoon);
        if ($seanceStart >= $seanceStartFilm && $seanceStart <= $seanceFinishFilm) {
//            dd('123');
            $freeTime = false;
        }
        if ($freeTime) {
            $data = $seanceStart;
//            $data[1]=$request['seance_start'];
//            $data = implode(" ", $data);
            Seance::query()->create([
                'hall_id' => $request->all()['hall_id'],
                'film_id' => $request->all()['film_id'],
                'seance_start' => $data,
            ]);
            $seance = DB::table('seances')
                ->where('hall_id', $request->all()['hall_id'])
                ->where('film_id', $request->all()['film_id'])
                ->where('seance_start', $data)->get();
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
        if (!$freeTime) {
            return redirect()->back()->with('status','Ошибка добавления сеанса, на эту дату и время есть уже сеанс. Ближайшее время ' . $comingSoon);
        }

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
