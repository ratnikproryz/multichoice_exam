<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

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
            //create token and store in personal_access_tokens table
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['user' => $user, "token" => $token]);
        }
        return response()->json([
            'message' => 'Your email or password is wrong. Please try again!'
        ], 500);
    }

    public function loginGoogle(Request $request)
    {
        $idToken = $request->input('id_token');
        $res = Http::get('https://oauth2.googleapis.com/tokeninfo?id_token=' . $idToken);
        $email = $res->json()['email'];
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => $res->json()['name'],
                'email' => $res->json()['email'],
                'avatar' => $res->json()['picture'],
            ]);
        }
        if (!$user->avatar) {
            $user->avatar = $res->json()['picture'];
            $user->save();
        }
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(['user' => $user, "token" => $token]);
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();
        $current_pwd = $request->input('current_pwd');
        $new_pwd = $request->input('new_pwd');
        $confirm_pwd = $request->input('confirm_pwd');
        if ($new_pwd === $confirm_pwd) {
            if (!$user->password || Hash::check($current_pwd, $user->password)) {
                $user->password = Hash::make($new_pwd);
                $user->save();
                return response()->json("Change password successfully!", 200);
            }
        }
        return response()->json("Change password failed! Please try again!", 417);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout'], 200);
    }
}
