<?php

namespace App\Presentation\Http\Controllers\Auth;

use App\Module\Auth\Services\LogoutService;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController
{
  public function __construct(private LogoutService $service) {}

  public function __invoke(Request $request): JsonResponse
  {
    // --- Service.
    ($this->service)($request->user());
    // --- Response.
    return ApiResponse::success(
      message: 'Logged out.',
      code: 200
      );
  }
}