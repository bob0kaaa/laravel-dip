<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user()->admin;
        $films = DB::table('films')->get();
        $seances = DB::table('seances')->get();
        $halls = DB::table('halls')->get();
        $seats = DB::table('seats')->get();
        $dateCurrent = $request->dateCurrent ?? substr(Carbon::now(), 0, 10);
        $dateChosen = $request->dateChosen ?? substr(Carbon::now(), 0, 10);
        $hall_holy =  $halls->first()->id;
        $i=0;
        foreach (Hall::all() as $value) {
            $value;
            if(count($value->seances)<=0) {
                $hall_holy = $value->id;
                break;
            }
            $i++;
        }
        $selected_hall = ($request->selected_hall) ?: $hall_holy;
        $open = $request->open;
        if ($request->open === null) {
            return redirect()->route('admin.open', ['param' => 0]);
        }
        $text= ($request->open == null || $request->open == '0' ) ? 'Открыть продажу билетов' : 'Приостановить продажу билетов';
        $i = session()->get('confStep');
        $confStep = $request['confStep'] ?: ['conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_closed', 'conf-step__header_closed'];

        return view('admin.index', [
            'confStep'=> $confStep,
            'open'=> $open,
            'text'=> $text,
            'selected_hall' => $selected_hall,
            'user'=> $user,
            'films' => $films,
            'halls' => $halls,
            'seances'=> $seances,
            'dateCurrent' => $dateCurrent,
            'dateChosen'=> $dateChosen,
            'seats'=> $seats
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        Admin::create([
//            'name' => Str::random(16).'user',
//            'email' => Hash::make('секрет').'@gmail.ru',
//            'password' => Hash::make('секрет'),
//        ]);
//        return redirect()->back();
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
