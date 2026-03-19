<?php

namespace App\Application\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController
{
    public function __construct(private AuthService $service)
    {}

    public function register(RegistrationRequest $request)
    {
        // Create User
        $user = $this->service->register($request->validated());
        // Response
        return ApiResponse::success(new UserResource($user), 'Реєстрація успішна!', 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        // Login
        $user = $this->service->login($request->validated());
        // Response
        return ApiResponse::success(new UserResource($user), 'Авторизація успішна!', 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::success(message: 'Вихід із системи.', code: 200);
    }
}
