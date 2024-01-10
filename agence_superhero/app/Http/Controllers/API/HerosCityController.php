<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HerosCity;

class HerosCityController extends Controller
{

    public function index()
    {
        $herosCities = HerosCity::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($herosCities);
    }


    public static function store(int $idHero, int $idCity )
    {
        $herosCity = new HerosCity;
        $herosCity->idHero = $idHero;
        $herosCity->idCity = $idCity;
        $herosCity->save();
    }

}
