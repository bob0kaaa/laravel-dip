<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmCreateRequest;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
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
    public function create(FilmCreateRequest $request)
    {
        $url = base_path() . '/public/upload/';
        if( $_FILES['image_path']['name'] != "" ) {
            $path=$_FILES['image_path']['name'];
            $pathto=$url.$path;
            move_uploaded_file( $_FILES['image_path']['tmp_name'],$pathto) or die( "Could not copy file!");
            DB::table('films')->insert([
                'title' => $request["title"],
                'description' => $request["description"],
                'duration' => $request["duration"] ?? 130,
                'image_path' => '/upload/' . $path,
                'image_text' => $request["title"],
                'origin'=> $request["origin"] ?? '',
            ]);
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
        if(count(Film::find($id)->seances)>0){
            return redirect()->back()->with('status','Ошибка удаления : для фильм ' ."/".Film::find($id)->title. "/".' существуют сеансы');
        } else {
            Film::find($id)->delete();
            return redirect()->back();
        }
    }

    public function seance()
    {
        try {
            $films = Film::all();
            foreach ($films as $film) {
                $film->seance()->where('hall_id', '=', 1)->get();
            }

            return response()->json([
                'success' => true,
                'data' => $films,
            ]);
        } catch (\Exception $e) {
            //error_log($e->getMessage());

            return response()->json([
                'success' => false,
            ], 500);
        }
    }
}
