<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\Auth\LoginRequest;
use App\Application\Http\Requests\Auth\RegistrationRequest;
use App\Application\Http\Resources\UserResource;
use App\Application\Http\Responses\ApiResponse;
use App\Domain\User\DTO\UserLoginDTO;
use App\Domain\User\Services\AuthService;
use App\Domain\User\DTO\UserRegistrationDTO;
use App\Domain\User\Exceptions\InvalidCredentialsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *  --- User Registration/Authentication Controller.
 * 1. Policy: bool|AuthorizationException.
 * 2. Request: DTO.
 * 3. Service: User.
 * 4. Response: JSON.
 */
class AuthController
{
  public function __construct(private AuthService $service) {}



  /**
   * User authentication flow.
   *
   * @param LoginRequest $request
   * @return JsonResponse
   */
  public function login(LoginRequest $request): JsonResponse
  {
    // --- DTO.
    $credentials = $request->validated();
    $dto = new UserLoginDTO(
      email: $credentials['email'],
      password: $credentials['password']
    );

    // --- Service.
    try {
      $response = $this->service->login($dto);
    } catch (InvalidCredentialsException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: 422
        );
    }

    // --- Response.
    return ApiResponse::success(
      data: [
        'user' => new UserResource($response['user']),
        'token' => $response['token']
      ],
      message: "Successful authentication!",
      code: 200
      );
  }

  public function logout(Request $request): JsonResponse
  {
    // --- Service.
    $this->service->logout($request->user());
    // --- Response.
    return ApiResponse::success(
      message: 'Logged out.',
      code: 200
      );
  }

  public function terminate(Request $request): JsonResponse
  {
    // --- Service.
    $this->service->terminate($request->user());
    // --- Response.
    return ApiResponse::success(
      message: 'Access terminated on all resources.',
      code: 200
      );
  }
}
