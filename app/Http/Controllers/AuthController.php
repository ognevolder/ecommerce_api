<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function __construct(private AuthService $service)
    {}

    public function register(RegistrationRequest $request): JsonResponse
    {
        // Create User
        $user = $this->service->register($request->validated());
        // Response
        if (! $user) {
            throw new ApiException('Не вдалося зареєструвати користувача.', 400);
        }
        return ApiResponse::success(new UserResource($user), 'Реєстрація успішна!', 201);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

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
