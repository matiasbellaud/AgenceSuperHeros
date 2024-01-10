<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\VehicleController;
use Illuminate\Http\Request;
use App\Models\Hero;

class HeroController extends Controller
{
    public function index()
    {
        $heros = Hero::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($heros);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'idUser' => ['required', 'int'],
                'name' => ['required', 'string', 'max:50'],
                'secretIdentity' => ['required', 'string', 'max:50'],
                'gender' => ['required', 'string', 'max:50'],
                'hairColor' => ['required', 'string', 'max:50'],
                'description' => ['required', 'string', 'max:50'],
                'planet' => ['required', 'string'],
                'superPower' => ['required', 'string'],
                'vehicle' => ['required', 'string'],
                // 'cities' => ['required', '[]string'],
                // 'gadgets' => ['required', '[]string'],
                // 'teams' => ['required', '[]string'],
                // 'power' => ['required', '[]string'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'succes' => 'false',
                'errors' => $e->errors(),
            ], 422);
        }

        //PLANET
        $planet = PlanetController::showName($request->input('planet'));
        $idplanet = $planet->id;

        //SUPER-POWER 
        $superPower = SuperPowerController::showName($request->input('superPower'));
        $idSuperPower = $superPower->id;
        
        // VEHICULE
        $vehicle = VehicleController::showName($request->input('vehicle'));
        $idVehicle = $vehicle->id;


        $hero = new Hero;
        $hero->idUser = $request->input('idUser');
        $hero->name = $request->input('name');
        $hero->secretIdentity = $request->input('secretIdentity');
        $hero->gender = $request->input('gender');
        $hero->hairColor = $request->input('hairColor');
        $hero->description = $request->input('description');
        $hero->idHomePlanet = $idplanet;
        $hero->idSuperPower = $idSuperPower;
        $hero->idVehicle = $idVehicle;
        $hero->save();

        //CITIES
        $cities = $request->input('cities');
        for($i = 0; $i < count($cities); ++$i) {
            $city = CityController::showName($cities[$i]);
            $idCity = $city->id;
            HerosCityController::store($hero->id, $idCity);
        }

        // //GADGETS
        $gadgets = $request->input('gadgets');
        for($i = 0; $i < count($gadgets); ++$i) {
            $gadget = GadgetController::showName($gadgets[$i]);
            $idGadget = $gadget->id;
            HerosGadgetController::store($hero->id, $idGadget);
        }

        // //TEAMS
        $teams = $request->input('teams');
        for($i = 0; $i < count($teams); ++$i) {
            $team = TeamController::showName($teams[$i]);
            $idTeam = $team->id;
            HerosTeamController::store($hero->id, $idTeam);
        }

        // //POWER
        $powers = $request->input('power');
        for($i = 0; $i < count($powers); ++$i) {
            $power = GadgetController::showName($powers[$i]);
            $idPower = $power->id;
            GadgetController::store($hero->id, $idPower);
        }

        return response()->json(['succes' => 'true'], 200);
    }

    public function showId(string $id)
    {
        $gadget = Gadget::find($id);
        return $gadget;  
    }

    public function showName(string $name)
    {
        $gadget = Gadget::where('name', $name)->first();
        return ($gadget);
    }
}
