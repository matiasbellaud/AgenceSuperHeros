<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HerosPower;

class HerosPowerController extends Controller
{
 
    public function index()
    {
        $herosPowers = HerosPower::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($herosPowers);
    }

    public static function store(int $idhero, int $idPower)
    {
        $herosPower = new HerosPower;
        $herosPower->idHero = $idhero;
        $herosPower->idPower = $idPower;
        $herosPower->save();
    }

    public static function showPowerByHero(int $idHero)
    {
        $idPower = HerosPower::where('idHero', $idHero)->get();
        if (count($idPower) == 0){
            return response()->json([
                'succes' => 'false',
                'errors' => "power not found",
            ], 404);
        } 
        $powers = array();
        for ($i = 0; $i<count($idPower);$i++){
            $power = PowerController::showId($idPower[$i]->idPower);
            array_push($powers, $power);
        }

        return ($powers);
    }
}
