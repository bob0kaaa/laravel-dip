<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmCreateRequest;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function create(Request $request)
    {
        $validated = validator($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'duration' => ['required', 'integer', 'max:200'],
            'origin' => ['required', 'string'],
            'image_text' => ['string'],
            'image_path' => ['required', 'file'],
        ])->validate();


        $path = $request->file('image_path')->store('upload');

        DB::table('films')->insert([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'duration' => $validated['duration'],
            'origin' => $validated['origin'],
            'image_path' => $path,
            'image_text' => 'poster film ' . 'title',
        ]);

        return redirect()->back();
    }
//return redirect()->back();
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
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->query->all()['id'];
        $imagePath = $request->all()['film']['image_path'];
        if( count($request->files) !== 0) {
            $imagePath = $request->all()['image_path']->store('upload');
        }
        $validated = validator($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'duration' => ['required', 'integer', 'max:200'],
            'origin' => ['required', 'string'],
        ])->validate();
        DB::table('films')
            ->where('id', $id)
            ->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'duration' => $validated['duration'],
                'image_path' => $imagePath,
                'origin' => $validated['origin'],
            ]);

        return redirect()->back();
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
