<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {

            $user   = Auth::user();
			$token  = $user->createToken("token")->plainTextToken;
 
            return response()->json([
                "status"    => "success",
                "message"   => "Successfuly Login",
                "token"     => $token
            ]);
        }
 
        return response()->json([
            "status"    => "error",
            "message"   => "Incorrect email / password",
        ],422);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "status"    => "success",
            "message"   => "Successfuly logout",
        ]);
    }

}
