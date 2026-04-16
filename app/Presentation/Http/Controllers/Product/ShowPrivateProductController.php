<?php

namespace App\Presentation\Http\Controllers\Product;

use App\Module\Product\Exceptions\ProductNotFoundException;
use App\Module\Product\Models\Product;
use App\Module\Product\Services\AdminProductService;
use App\Presentation\Http\Resources\Product\ProductResource;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ShowPrivateProductController
{
  public function __construct(private AdminProductService $service) {}

  public function __invoke(Product $product): JsonResponse
  {
    // --- Policy.
    try {
      Gate::authorize('show', $product);
    } catch (AuthorizationException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: 403
      );
    }

    // --- Service.
    try {
      $response = $this->service->show($product->id);
    } catch (ProductNotFoundException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: $e->getCode()
      );
    }

    // --- Response.
    return ApiResponse::success(
      data: new ProductResource($response),
      message: "Product model with selected ID: {$product->id}.",
      code: 200
      );
  }
}