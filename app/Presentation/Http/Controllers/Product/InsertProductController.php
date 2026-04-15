<?php

namespace App\Presentation\Http\Controllers\Product;

use App\Module\Product\DTO\InsertProductDTO;
use App\Module\Product\Exceptions\InvalidAttributesException;
use App\Module\Product\Models\Product;
use App\Module\Product\Services\AdminProductService;
use App\Presentation\Http\Requests\Product\StoreProductRequest;
use App\Presentation\Http\Resources\Product\ProductResource;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class InsertProductController
{
  public function __construct(private AdminProductService $service) {}

  public function __invoke(StoreProductRequest $request): JsonResponse
  {
    $attributes = $request->validated();

    // --- Policy.
    try {
      Gate::authorize('insert', Product::class);
    } catch (AuthorizationException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: 403
      );
    }

    // --- DTO.
    $dto = new InsertProductDTO(
      title: $attributes->title,
      description: $attributes->description,
      quantity: $attributes->quantity,
      price: $attributes->price,
      admin_id: $request->user()->id
      );

    // --- Service.
    try {
      $product = $this->service->insert($dto);
    } catch (InvalidAttributesException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: $e->getCode()
      );
    }

    // --- Response.
    return ApiResponse::success(
      data: new ProductResource($product),
      message: "Product {$product->title} was successfully inserted.",
      code: 201
      );
  }
}
