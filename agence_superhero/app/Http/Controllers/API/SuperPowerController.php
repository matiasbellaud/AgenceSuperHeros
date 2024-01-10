<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuperPower;

class SuperPowerController extends Controller
{

    public function index()
    {
        $superPowers = SuperPower::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($superPowers);
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:50'],
                'description' => ['required', 'string', 'max:50'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'succes' => 'false',
                'errors' => $e->errors(),
            ], 422);
        }
        $superPower = new SuperPower;
        $superPower->name = $request->input('name');
        $superPower->description = $request->input('description');
        $superPower->save();
        return response()->json(['succes' => 'true'], 200);
    }

    public function showId(string $id)
    {
        $superPower = SuperPower::find($id);
        return $superPower;  
    }

    public static function showName(string $name)
    {
        $superPower = SuperPower::where('name', $name)->first();
        return ($superPower);
    }
}
