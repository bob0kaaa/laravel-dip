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
        $films = DB::table('films')->get();
        $halls = DB::table('halls')->get();
        $seances = DB::table('seances')->get();
        $seats = DB::table('seats')->get();
        $dateCurrent = $request->date_current ?? substr(Carbon::now(), 0, 10);
        $dateChosen  = $request->date_chosen ?? substr(Carbon::now(), 0, 10);
        return view('home.index',
            [
                'films' => $films,
                'halls' => $halls,
                'seances'=> $seances,
                'seats'=> $seats,
                'dateCurrent' => $dateCurrent,
                'dateChosen'=> $dateChosen,
            ]);
        $query = Film::query();
        dd($query);
    }

}
