<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            DB::commit();
            return response()->json($user);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) { //if email and password are valid
            $token = $user->createToken('authToken')->plainTextToken; //create token and store in personal_access_tokens table
            return response()->json(['user' => $user, "token" => $token]);
        }
        return response()->json(['message' => 'Your email or password is wrong. Please try again!'], 500);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete(); 
        return response()->json([
            'message' => 'Logout'
        ], 200);
    }   
}
