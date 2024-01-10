<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HerosGadget;


class HerosGadgetController extends Controller
{

    public function index()
    {
        $herosGadgets = HerosGadget::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($herosGadgets);
    }

    public static function store(int $idHero, int $idGadget)
    {
        $herosGadget = new HerosGadget;
        $herosGadget->idHero = $idHero;
        $herosGadget->idGadget = $idGadget;
        $herosGadget->save();
    }

}
