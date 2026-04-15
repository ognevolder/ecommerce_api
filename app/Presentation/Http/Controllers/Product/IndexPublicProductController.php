<?php

namespace App\Presentation\Http\Controllers\Product;

use App\Module\Product\Exceptions\EmptyProductCollectionException;
use App\Module\Product\Services\PublicProductService;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class IndexPublicProductController
{
  public function __construct(private PublicProductService $service) {}

  public function __invoke(): JsonResponse
  {
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