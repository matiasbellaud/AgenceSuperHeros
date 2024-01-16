<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function register(Request $request)
    {
        try {
            $request->validate([
                'firstName' => ['required', 'string', 'max:30'],
                'lastName' => ['required', 'string', 'max:30'],
                'email' => ['required', 'string', 'max:100'],
                'password' => ['required', 'string', 'max:50'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'succes' => 'false',
                'errors' => $e->errors(),
            ], 422);
        }
        $user = new User;
        $user->firstName = $request->input('firstName');
        $user->lastName = $request->input('lastName');
        $user->email = $request->input('email');
        $user->password = hash('sha256',$request->input('password'));
        $user->save();
        return response()->json(['succes' => 'true'], 200);
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'string', 'max:100'],
                'password' => ['required', 'string', 'max:50'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'succes' => 'false',
                'errors' => $e->errors(),
            ], 422);
        }
       
        $user = User::where('email', $request->email)->first();
        if ($user==null){
            return response()->json(-1);
        }
        $logPassword = hash('sha256',$request->password);
        if ($logPassword == $user->password){
            return response()->json($user->id);
        }
        return response()->json(-1);
    }
}
