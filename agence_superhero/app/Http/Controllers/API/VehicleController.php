<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($vehicles);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:50'],
                'description' => ['required', 'string', 'max:50'],
                'type' => ['required', 'string', 'max:50'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'succes' => 'false',
                'errors' => $e->errors(),
            ], 422);
        }
        $vehicle = new Vehicle;
        $vehicle->name = $request->input('name');
        $vehicle->description = $request->input('description');
        $vehicle->type = $request->input('type');
        $vehicle->save();
        return response()->json(['succes' => 'true'], 200);
    }

    public static function storeForHero(string $name)
    {
        $vehicle = new Vehicle;
        $vehicle->name = $name;
        $vehicle->description = "temporaire a revenir dessus";
        $vehicle->type = "temporaire a revenir dessus";
        $vehicle->save();
        return $vehicle;
    }

    public static function showId(string $id)
    {
        $vehicle = Vehicle::find($id);
        return $vehicle;  
    }

    public static function showName(string $name)
    {
        $vehicle = Vehicle::where('name', $name)->first();
        return $vehicle;
    }
}
