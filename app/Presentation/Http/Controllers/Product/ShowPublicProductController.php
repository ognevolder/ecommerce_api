<?php

namespace App\Presentation\Http\Controllers\Product;

use App\Module\Product\Exceptions\ProductNotFoundException;
use App\Module\Product\Services\PublicProductService;
use App\Presentation\Http\Resources\Product\ProductResource;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;

class ShowPublicProductController
{
  public function __construct(private PublicProductService $service) {}

  public function __invoke(int $id): JsonResponse
  {
    // --- Service.
    try {
      $product = $this->service->show($id);
    } catch (ProductNotFoundException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: $e->getCode()
      );
    }

    // --- Response.
    return ApiResponse::success(
      data: new ProductResource($product),
      message: "Product model with selected ID: {$product->id}.",
      code: 200
      );
  }
}