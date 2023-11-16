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
//        dd($request);
        $halls = DB::table('halls')->get()->sortBy('name');
        $films = DB::table('films')->get();
        $seances = DB::table('seances')->get();
        $selected_hall = ($request->selected_hall) ?: $halls->first()->id;
        return view('admin.index', ['halls' => $halls, 'selected_hall' => $selected_hall, 'films' => $films, 'seances' => $seances]);
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
    public function delete(string $id)
    {
//        dd($id);
    }
}
