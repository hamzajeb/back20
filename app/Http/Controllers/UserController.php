<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
class UserController extends Controller
{
    //
    public function register(Request $request)
    {
        // 'nom',
        // 'prenom',
        // 'sexe',
        // 'ville',
        // 'telephone',
        // 'email',
        // 'password',
        // 'is_admin'
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,
            'ville' => $request->ville,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return new UserResource($user);
    }

    public function login(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'message' => 'connected succefuly',
                    'status_code' => 200,
                    'access_token' => $token,
                    'sanctumToken' => 'Bearer ' . $token,
                    'user' => $user,
                    // 'role' => $user->getRoleNames()
                ]);
            } else {
                return response()->json([
                    'message' => 'invalide mot de passe',
                ]);
            }
        } else {
            return response()->json([
                'message' => 'invalide email',
            ]);
        }
    }
    public function profile()
    {
        return new UserResource(auth()->user());
    }
    public function logout()
    {

        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'LogOut Done ',
        ]);
    }

    public function favUsers($id){
        $favorites = User::with('fav')->get()->find($id);
        return  response()->json($favorites);
    }
}
