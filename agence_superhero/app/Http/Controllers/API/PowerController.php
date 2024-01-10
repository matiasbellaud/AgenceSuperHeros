<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Power;

class PowerController extends Controller
{
  
    public function index()
    {
        $powers = Power::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($powers);
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
        $power = new Power;
        $power->name = $request->input('name');
        $power->description = $request->input('description');
        $power->save();
        return response()->json(['succes' => 'true'], 200);
    }

    public function showId(string $id)
    {
        $power = Power::find($id);
        return $power;  
    }

    public function showName(string $name)
    {
        $power = Power::where('name', $name)->first();
        return ($power);
    }
}
