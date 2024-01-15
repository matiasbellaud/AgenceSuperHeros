<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($cities);
    }

    /**
     * Store a newly created resource in storage.
     */
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
        $city = new City;
        $city->name = $request->input('name');
        $city->save();
        return response()->json(['succes' => 'true'], 200);
    }

    public static function storeForHero(string $name)
    {
       
        $city = new City;
        $city->name = $name;
        $city->save();
        return $city;
    }

    public static function showId(string $id)
    {
        $cityRecord = City::find($id);
        return $cityRecord;  
    }

    public static function showName(string $name)
    {
        $cityRecord = City::where('name', $name)->first();
        return ($cityRecord);
    }
}
