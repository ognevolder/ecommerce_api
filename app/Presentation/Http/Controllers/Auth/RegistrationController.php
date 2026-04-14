<?php

 namespace App\Presentation\Http\Controllers\Auth;

use App\Module\Auth\DTOs\UserRegistrationDTO;
use App\Module\Auth\Services\RegistrationService;
use App\Presentation\Http\Requests\Auth\RegistrationRequest;
use App\Presentation\Http\Resources\Auth\UserResource;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

 class RegistrationController
 {
  public function __construct(private RegistrationService $service) {}

  /**
   * User registration flow.
   *
   * @param RegistrationRequest $request
   * @return JsonResponse
   */
  public function __invoke(RegistrationRequest $request): JsonResponse
  {
    // --- DTO.
    $attributes = $request->validated();
    $dto = new UserRegistrationDTO(
      name: $attributes['name'],
      email: $attributes['email'],
      password: $attributes['password']
    );

    // --- Service.
    $user = ($this->service)($dto);

    // --- Response.
    return ApiResponse::success(
      data: new UserResource($user),
      message: 'Successful registration!',
      code: 201
      );
  }
 }