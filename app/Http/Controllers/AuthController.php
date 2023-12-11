<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function register(Request $request){
        $request->validate([
            "emmil"  => "required|unique:users,email",
            "password" => "required|min:8|max:32",
        ]);

        $data   = new User();
        $data->email     = $request->input("email");
        $data->password     = Hash::make($request->input("password"));
        if($data->save()){
            return response()->json([
                "status"    => "success",
                "message"   => "Successfuly register"
            ]);
        }
        
        return response()->json([
            "status"    => "error",
            "message"   => "Failed, please try again"
        ]);
    }

}
