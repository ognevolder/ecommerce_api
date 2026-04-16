<?php

namespace App\Presentation\Http\Controllers\Product;

use App\Module\Product\Exceptions\EmptyProductCollectionException;
use App\Module\Product\Models\Product;
use App\Module\Product\Services\AdminProductService;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class IndexPrivateProductController
{
  public function __construct(private AdminProductService $service) {}

  public function __invoke(): JsonResponse
  {
    // --- Policy.
    try {
      Gate::authorize('viewAll', Product::class);
    } catch (AuthorizationException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: 403
      );
    }

    // --- Service.
    try {
      $collection = $this->service->index();
    } catch (EmptyProductCollectionException $e)
    {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: $e->getCode()
      );
    }

    // --- Response.
    return ApiResponse::success(
      data: $collection,
      message: "List of all Product models with status 'Public'.",
      code: 200
    );
  }
}