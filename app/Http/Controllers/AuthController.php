<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\LoggedUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function login(LoginRequest $request): JsonResponse
    {
        // Fetch User
        $user = User::where('email', $request->email)->first();
        // Login
        $loggedUser = $this->service->login($request->validated(), $user);
        // Response
        return ApiResponse::success(
            new LoggedUserResource($loggedUser),
            'Успішний вхід у систему.',
            200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::success(message: 'Вихід із системи.', code: 200);
    }
}
