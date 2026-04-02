<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Resources\ProductResource;
use App\Application\Http\Responses\ApiResponse;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

/**
 *  --- Admin (CMS) Controller.
 * 1. Policy: bool|AuthorizationException.
 * 2. Request: DTO.
 * 3. Service: Product.
 * 4. Response: JSON.
 */
class AdminController
{
  public function __construct(private AdminService $service) {}

  public function list(): JsonResponse
  {
    // --- Policy.
    Gate::authorize('list', Product::class);

    // --- Service.
    $collection = $this->service->list();

    // --- Response.
    return ApiResponse::success(
      data: $collection,
      message: "Products list.",
      code: 200
    );
  }

  public function show(int $id): JsonResponse
  {
    // --- Policy.
    Gate::authorize('show', Product::class);

    // --- Service.
    $product = $this->service->show($id);

    // --- Response.
    return ApiResponse::success(
      data: new ProductResource($product),
      message: "Product with selected ID.",
      code: 200
    );
  }
}