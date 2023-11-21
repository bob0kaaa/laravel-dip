<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        dd($request->all());
        $dateCurrent = $request->all()['dateCurrent'] ?? substr(Carbon::now(), 0, 10);
        $dateChosen  = $request->all()['dateChosen'] ?? substr(Carbon::now(), 0, 10);

        $halls = DB::table('halls')->get();
        $seances = DB::table('seances')->get();
        $seats = DB::table('seats')->get();

        $films = DB::table('films')->get();
        return view('home.index',
            [
                'films' => $films,
                'halls' => $halls,
                'seances'=> $seances,
                'seats'=> $seats,
                'dateCurrent' => $dateCurrent,
                'dateChosen'=> $dateChosen,
            ]);

    }

}
