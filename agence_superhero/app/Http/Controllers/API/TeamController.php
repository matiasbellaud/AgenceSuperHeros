<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    
    public function index()
    {
        $teams = Team::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($teams);
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
        $team = new Team;
        $team->name = $request->input('name');
        $team->save();
        return response()->json(['succes' => 'true'], 200);
    }

    public static function storeForHero(string $name)
    {
        
        $team = new Team;
        $team->name = $name;
        $team->save();
        return $team;
    }

    public function showId(string $id)
    {
        $team = Team::find($id);
        return $team;  
    }

    public static function showName(string $name)
    {
        $team = Team::where('name', $name)->first();
        return ($team);
    }
}
