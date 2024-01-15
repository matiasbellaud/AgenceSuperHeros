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
        if ($planet == null){
            $planet = PlanetController::storeForHero($request->input('planet'));
        }
        $idplanet = $planet->id;

        //SUPER-POWER 
        $superPower = SuperPowerController::showName($request->input('superPower'));
        if ($superPower == null){
            $superPower = SuperPowerController::storeForHero($request->input('superPower'));
        }
        $idSuperPower = $superPower->id;
        
        // VEHICULE
        $vehicle = VehicleController::showName($request->input('vehicle'));
        if ($vehicle == null){
            $vehicle = VehicleController::storeForHero($request->input('vehicle'));
        }
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
            if ($city == null){
                $city = CityController::storeForHero($cities[$i]);
            }
            $idCity = $city->id;
            HerosCityController::store($hero->id, $idCity);
        }

        // //GADGETS
        $gadgets = $request->input('gadgets');
        for($i = 0; $i < count($gadgets); ++$i) {
            $gadget = GadgetController::showName($gadgets[$i]);
            if ($gadget == null){
                $gadget = GadgetController::storeForHero($gadgets[$i]);
            }
            $idGadget = $gadget->id;
            HerosGadgetController::store($hero->id, $idGadget);
        }

        // //TEAMS
        $teams = $request->input('teams');
        for($i = 0; $i < count($teams); ++$i) {
            $team = TeamController::showName($teams[$i]);
            if ($team == null){
                $team = TeamController::storeForHero($teams[$i]);
            }
            $idTeam = $team->id;
            HerosTeamController::store($hero->id, $idTeam);
        }

        // //POWER
        $powers = $request->input('power');
        for($i = 0; $i < count($powers); ++$i) {
            $power = PowerController::showName($powers[$i]);
            if ($power == null){
                $power = PowerController::storeForHero($powers[$i]);
            }
            $idPower = $power->id;
            HerosPowerController::store($hero->id, $idPower);
        }

        return response()->json(['succes' => 'true'], 200);
    }

    
    public function getHeroesByUser(Request $request)
    {
        
        try {
            $request->validate([
                'idUser' => ['required', 'int'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'succes' => 'false',
                'errors' => $e->errors(),
            ], 422);
        }
        $heroes = Hero::where('idUser', $request->idUser)->get();
        for ($i = 0; $i<count($heroes);$i++){
            //PLANET
            $planet = PlanetController::showId($heroes[$i]->idHomePlanet);
            if ($planet == null){
                return response()->json([
                    'succes' => 'false',
                    'errors' => "planet not found",
                ], 404);
            } 
            $heroes[$i]->idHomePlanet = $planet->name;

            //SUPER-POWER
            $superPower = SuperPowerController::showId($heroes[$i]->idSuperPower);
            if ($superPower == null){
                return response()->json([
                    'succes' => 'false',
                    'errors' => "super-power not found",
                ], 404);
            } 
            $heroes[$i]->idSuperPower = $superPower->name;

            //VEHICLE
            $vehicle = VehicleController::showId($heroes[$i]->idVehicle);
            if ($vehicle == null){
                return response()->json([
                    'succes' => 'false',
                    'errors' => "vehicle not found",
                ], 404);
            } 
            $heroes[$i]->idVehicle = $vehicle->name;


            //finir avec les 4 autres mais en passant par leur table de liaisons
        }
        return response()->json($heroes);
    }

    public function showId(string $id)
    {
        $hero = Hero::find($id);
        return $hero;  
    }

    public function showName(string $name)
    {
        $hero = Hero::where('name', $name)->first();
        return ($hero);
    }
}
