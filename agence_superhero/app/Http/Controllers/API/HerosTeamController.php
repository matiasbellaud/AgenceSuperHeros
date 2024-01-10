<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HerosTeam;

class HerosTeamController extends Controller
{
  
    public function index()
    {
        $herosTeams = HerosTeam::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($herosTeams);
    }

   
    public static function store(int $idHero, int $idTeam)
    {
        $herosTeam = new HerosTeam;
        $herosTeam->idHero = $idHero;
        $herosTeam->idTeam = $idTeam;
        $herosTeam->save();
    }

}
