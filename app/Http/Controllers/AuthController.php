<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        //Validate data
        $attributes = $request->validated();
        //Create user
        $user = User::create($attributes);
        //Return token
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
        //Response
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(LoginRequest $request)
    {
        //Validation
        $credentials = $request->validated();
        $status = Auth::attempt($credentials);
        //Login
        if (! $status)
            {
                return response()->json([
                    'message' => 'Error is occured.',
                    'status' => '401'
                ]);
            }

        $user = User::where('email', $request->email)->first();
        $role = $user->role;
        $user->tokens()->delete();
        $token = $user->createToken('auth_token', [$role], Carbon::now()->addMinutes(180))->plainTextToken;
        //Response/redirect
        return response()->json([
            'message' => 'Logged In',
            'user' => $user,
            'role' => $user->role,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged Out'
        ]);
    }
}
