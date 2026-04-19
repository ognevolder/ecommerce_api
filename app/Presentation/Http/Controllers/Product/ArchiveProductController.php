<?php

namespace App\Presentation\Http\Controllers\Product;

use App\Module\Product\Exceptions\TransitionDeniedException;
use App\Module\Product\Models\Product;
use App\Module\Product\Services\AdminProductService;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ArchiveProductController
{
  public function __construct(
    private AdminProductService $service
  ) {}

  public function __invoke(int $id): JsonResponse
  {
    // --- Policy.
    Gate::authorize('archive', Product::class);

    // --- Service.
    try {
      $this->service->archive($id);
    } catch (TransitionDeniedException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: $e->getCode()
      );
    }

    // --- Response.
    return ApiResponse::success(
      data: null,
      message: "Product with ID [$id] is successfuly archived.",
      code: 200
    );
  }
}