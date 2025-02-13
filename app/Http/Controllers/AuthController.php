<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function auth(Request $request)
    {
        $request->validate([
            "email" => "required|email|exist:users,email",
            "password" => "required|confirmed",

        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash
        ::check($request->password, $user->password)) {
            return response([
                'message' => 'wrong password!'
            ]);
        }

        $token = $user->createToken($user->name . '-AuthToken')
        ->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);


        return response()->json([
           'message' => 'register successfully!',
        ], 201);
    }
}
