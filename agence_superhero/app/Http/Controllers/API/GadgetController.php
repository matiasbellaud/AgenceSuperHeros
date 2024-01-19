<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gadget;

class GadgetController extends Controller
{
    public function index()
    {
        $gadgets = Gadget::all();
        
        // On retourne les informations des utilisateurs en JSON
        return response()->json($gadgets);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:50'],
                'description' => ['required', 'string', 'max:50'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'succes' => 'false',
                'errors' => $e->errors(),
            ], 422);
        }
        $gadget = new Gadget;
        $gadget->name = $request->input('name');
        $gadget->description = $request->input('description');
        $gadget->save();
        return response()->json(['succes' => 'true'], 200);
    }

    public static function storeForHero(string $name)
    {
        
        $gadget = new Gadget;
        $gadget->name = $name;
        $gadget->description = "temporaire a revenir dessus";
        $gadget->save();
        return $gadget;
    }

    public static function showId(string $id)
    {
        $gadget = Gadget::find($id);
        return $gadget;   
    }

    public static function showName(string $name)
    {
        $gadget = Gadget::where('name', $name)->first();
        return ($gadget);
    }
}
