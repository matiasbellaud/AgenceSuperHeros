<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Film;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = Film::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($films);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => ['required', 'string', 'max:100'],
                'year' => ['required', 'numeric', 'min:1950', 'max:' . date('Y')],
                'description' => ['required', 'string', 'max:500'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'succes' => 'false',
                'errors' => $e->errors(),
            ], 422);
        }
        $user = new Film;
        $user->title = $request->input('title');
        $user->year = $request->input('year');
        $user->description = $request->input('description');
        $user->category_id = $request->input('category_id');
        $user->save();
        return response()->json(['succes' => 'true'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $films = Film::find($id);
        // $films = Film::where('id','=', strval($id));
        return $films;  
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
