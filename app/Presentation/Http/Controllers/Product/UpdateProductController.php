<?php

namespace App\Presentation\Http\Controllers\Product;

use App\Module\Product\DTOs\UpdateProductDTO;
use App\Module\Product\Exceptions\InvalidAttributesException;
use App\Module\Product\Models\Product;
use App\Module\Product\Services\AdminProductService;
use App\Presentation\Http\Requests\Product\UpdateProductRequest;
use App\Presentation\Http\Resources\Product\ProductResource;
use App\Presentation\Http\Responses\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class UpdateProductController
{
  public function __construct(private AdminProductService $service) {}

  public function __invoke(UpdateProductRequest $request, Product $product): JsonResponse
  {
    $attributes = $request->validated();

    // --- Policy.
    try {
      Gate::authorize('update', $product);
    } catch (AuthorizationException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: 403
      );
    }

    // --- Dto.
    $dto = new UpdateProductDTO(
      attributes: [
        'title' => $attributes['title'],
        'description' => $attributes['description'],
        'quantity' => $attributes['quantity'],
        'price' => $attributes['price']
      ],
      admin_id: $request->user()->id,
      product_id: $product->id
    );

    // --- Service.
    try {
      $product = $this->service->update($dto);
    } catch (InvalidAttributesException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: $e->getCode()
      );
    }

    // --- Response.
    return ApiResponse::success(
      data: new ProductResource($product),
      message: "Product {$product->title} was successfully updated.",
      code: 201
      );
  }
}