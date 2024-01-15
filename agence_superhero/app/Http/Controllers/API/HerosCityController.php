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

    public static function showCityByHero(string $idHero)
    {
        $idCity = HerosCity::where('idHero', $idHero)->get();
        if (count($idCity) == 0){
            return response()->json([
                'succes' => 'false',
                'errors' => "city not found",
            ], 404);
        } 
        $cities = array();
        for ($i = 0; $i<count($idCity);$i++){
            $city = CityController::showId($idCity[$i]->idCity);
            array_push($cities, $city);
        }
        return ($cities);
    }

}
