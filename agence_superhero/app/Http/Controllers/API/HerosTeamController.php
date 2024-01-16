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

    public static function showTeamByHero(int $idHero)
    {
        $idTeam = HerosTeam::where('idHero', $idHero)->get();
        $teams = array();
        for ($i = 0; $i<count($idTeam);$i++){
            $team = TeamController::showId($idTeam[$i]->idTeam);
            array_push($teams, $team);
        }

        return ($teams);
    }

}
