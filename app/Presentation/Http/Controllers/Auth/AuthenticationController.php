<?php

namespace App\Presentation\Http\Controllers\Auth;

use App\Module\Auth\DTOs\UserLoginDTO;
use App\Module\Auth\Exceptions\InvalidCredentialsException;
use App\Module\Auth\Services\AuthenticationService;
use App\Presentation\Http\Requests\Auth\LoginRequest;
use App\Presentation\Http\Resources\Auth\UserResource;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class AuthenticationController
{
  public function __construct(private AuthenticationService $service) {}

  public function __invoke(LoginRequest $request): JsonResponse
  {
    // --- DTO.
    $credentials = $request->validated();
    $dto = new UserLoginDTO(
      email: $credentials['email'],
      password: $credentials['password']
    );

    // --- Service.
    try {
      $response = ($this->service)($dto);
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
}