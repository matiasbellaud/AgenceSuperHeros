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
        $hero->idVehicle = $idVehicle;
        
        $hero->save();
        
        
        //CITIES
        $cities = $request->input('cities');
        for($i = 0; $i < count($cities); ++$i) {
            $city = CityController::showName($cities[$i]);
            if ($city == null){
                print("test");
                $city = CityController::storeForHero($cities[$i]);
            }
            $idCity = $city->id;
            HerosCityController::store($hero->id, $idCity);
        }

        //GADGETS
        if (count($request->input('gadgets')) != 0){
            $gadgets = $request->input('gadgets');
            for($i = 0; $i < count($gadgets); ++$i) {
                $gadget = GadgetController::showName($gadgets[$i]);
                if ($gadget == null){
                    $gadget = GadgetController::storeForHero($gadgets[$i]);
                }
                $idGadget = $gadget->id;
                HerosGadgetController::store($hero->id, $idGadget);
            }
        }
        

        //TEAMS
        $teams = $request->input('teams');
        for($i = 0; $i < count($teams); ++$i) {
            $team = TeamController::showName($teams[$i]);
            if ($team == null){
                $team = TeamController::storeForHero($teams[$i]);
            }
            $idTeam = $team->id;
            HerosTeamController::store($hero->id, $idTeam);
        }

        //POWER
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

            //VEHICLE
            $vehicle = VehicleController::showId($heroes[$i]->idVehicle);
            if ($vehicle == null){
                return response()->json([
                    'succes' => 'false',
                    'errors' => "vehicle not found",
                ], 404);
            } 
            $heroes[$i]->idVehicle = $vehicle->name;

            //CITY
            $cities = HerosCityController::showCityByHero($heroes[$i]->id);
            $citiesName = array();
            for ($j=0;$j<count($cities);$j++){
                array_push($citiesName, $cities[$j]->name);
            }
            $heroes[$i]->cities = $citiesName;

            //POUVOIR
            $powers = HerosPowerController::showPowerByHero($heroes[$i]->id);
            $powersName = array();
            for ($j=0;$j<count($powers);$j++){
                array_push($powersName, $powers[$j]->name);
            }
            $heroes[$i]->powers = $powersName;

            //GADGET
            $gadgets = HerosGadgetController::showGadgetByHero($heroes[$i]->id);
            $gadgetsName = array();
            for ($j=0;$j<count($gadgets);$j++){
                array_push($gadgetsName, $gadgets[$j]->name);
            }
            $heroes[$i]->gadgets = $gadgetsName;

            //TEAM
            $teams = HerosTeamController::showTeamByHero($heroes[$i]->id);
            $teamsName = array();
            for ($j=0;$j<count($teams);$j++){
                array_push($teamsName, $teams[$j]->name);
            }
            $heroes[$i]->teams = $teamsName;
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
