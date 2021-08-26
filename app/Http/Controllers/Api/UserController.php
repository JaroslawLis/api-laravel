<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // USER REGISTER API - POST
    public function register(Request $request)
    {
        // validation
        $request->validate([
            "name" => "required|min:2|max:50",
            "surname" => "required|min:2|max:100",
            "email" => "required|email|unique:users",
            "password" =>
            [
                'required', 'confirmed', 'max:250', Password::min(7)
                    ->mixedCase()
            ],
        ]);

        //create user data + save

        $user = new User();

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        // send response

        return response()->json([
            "status" => 1,
            "message" => "Author registered successfully"
        ], 200);
    }
    // USER LOGIN API - POST
    public function login(Request $request)
    {

        // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // verify user + token
        if (!$token = auth()->attempt(["email" => $request->email, "password" => $request->password])) {
            return response()->json([
                "status" => 0,
                "message" => "Invalid credentials"
            ]);
        }

        //send response
        return response()->json([
            "status" => 1,
            "message" =>  "Logged in successfully",
            "access_token" => $token
        ]);
    }

    // USER PROFILE API - GET
    public function logout()
    {
        auth()->logout();

        return response()->json([
            "status" => 1,
            "message" => "user log out"
        ]);
    }
}
