<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Planet;

class PlanetController extends Controller
{
    
    public function index()
    {
        $planets = Planet::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($planets);
    }

   
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:50'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'succes' => 'false',
                'errors' => $e->errors(),
            ], 422);
        }
        $planet = new Planet;
        $planet->name = $request->input('name');
        $planet->save();
        return response()->json(['succes' => 'true'], 200);
    }

    public function showId(string $id)
    {
        $planet = Planet::find($id);
        return $planet;  
    }

    public static function showName(string $name)
    {
        $planet = Planet::where('name', $name)->first();
        return ($planet);
    }
}
