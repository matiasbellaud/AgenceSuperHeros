<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\VehicleController;
use Illuminate\Http\Request;
use App\Models\Hero;
use App\Models\HerosCity;
use App\Models\HerosGadget;
use App\Models\HerosPower;
use App\Models\HerosTeam;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API projet Ynov Laravel"
 * )
 * 
 * @OA\Post(
 *     path="/api/post/getHeroesByUser",
 *     summary="get all heros info by user ID",
 *     @OA\Response(response=200, description="all data from heros")
 * )
 * @OA\Post(
 *     path="/api/post/createHero",
 *     summary="create one hero info",
 *     @OA\Response(response=200, description="success")
 * )
 * @OA\Post(
 *     path="/api/post/deleteHeroById",
 *     summary="delete hero by id",
 *     @OA\Response(response=200, description="success")
 * )
 * @OA\Post(
 *     path="/api/post/register",
 *     summary="register the account",
 *     @OA\Response(response=201, description="success")
 * ) 
 * @OA\Post(
 *     path="/api/post/login",
 *     summary="login account",
 *     @OA\Response(response=201, description="data idUser")
 * )
 *
 */

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
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'succes' => 'false',
                'errors' => $e->errors(),
            ], 422);
        }

        //ERROR POWER
        $powersTest = $request->input('power');
        $powersTestCount = 0;
        for($i = 0; $i < count($powersTest); ++$i) {
            if ($powersTest[$i] == null){
                $powersTestCount++;
            }
        }
        
        if ($powersTestCount == count($powersTest)){
            return;
        }

        //ERROR CITY
        $citiesTest = $request->input('cities');
        $citiesTestCount = 0;

        for($i = 0; $i < count($citiesTest); ++$i) {
            if ($citiesTest[$i] == null){
                $citiesTestCount++;
            }
        }
        if ($citiesTestCount == count($citiesTest)){
            return;
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
            if ($cities[$i] != null){
                $city = CityController::showName($cities[$i]);
                if ($city == null){
                    print("test");
                    $city = CityController::storeForHero($cities[$i]);
                }
                $idCity = $city->id;
                HerosCityController::store($hero->id, $idCity);
            }
        }

        //GADGETS
        if (count($request->input('gadgets')) != 0){
            $gadgets = $request->input('gadgets');
            for($i = 0; $i < count($gadgets); ++$i) {
                if ($gadgets[$i] != null){
                    $gadget = GadgetController::showName($gadgets[$i]);
                    if ($gadget == null){
                        $gadget = GadgetController::storeForHero($gadgets[$i]);
                    }
                    $idGadget = $gadget->id;
                    HerosGadgetController::store($hero->id, $idGadget);
                }
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
            if ($powers[$i] != null){
                $power = PowerController::showName($powers[$i]);
                if ($power == null){
                    $power = PowerController::storeForHero($powers[$i]);
                }
                $idPower = $power->id;
                HerosPowerController::store($hero->id, $idPower);
            }
        }

        return response()->json("success");
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

    public function deleteHeroById(Request $request)
    {
        print("test");
        try {
            $request->validate([
                'idHero' => ['required', 'int'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'succes' => 'false',
                'errors' => $e->errors(),
            ], 422);
        }
        
        $cities = HerosCity::where('idHero', $request->idHero)->get();
        $gadgets = HerosGadget::where('idHero', $request->idHero)->get();
        $powers = HerosPower::where('idHero', $request->idHero)->get();
        $teams = HerosTeam::where('idHero', $request->idHero)->get();

        for ($i=0;$i<count($cities);$i++){
            HerosCity::where('id', $cities[$i]->id)->delete();
        }
        for ($i=0;$i<count($gadgets);$i++){
            HerosGadget::where('id', $gadgets[$i]->id)->delete();
        }
        for ($i=0;$i<count($powers);$i++){
            HerosPower::where('id', $powers[$i]->id)->delete();
        }
        for ($i=0;$i<count($teams);$i++){
            HerosTeam::where('id', $teams[$i]->id)->delete();
        }
        $hero = Hero::where('id', $request->idHero)->delete();

        return response()->json("success");
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
