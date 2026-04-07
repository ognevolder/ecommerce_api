<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\Product\StoreProductRequest;
use App\Application\Http\Resources\ProductResource;
use App\Application\Http\Responses\ApiResponse;
use App\Domain\Product\DTO\InsertProductDTO;
use App\Domain\Product\Exceptions\InvalidAttributesException;
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

  public function insert(StoreProductRequest $request): JsonResponse
  {
    $attributes = $request->validated();

    // --- Policy.
    Gate::authorize('insert', Product::class);

    // --- DTO.
    $dto = new InsertProductDTO(
      title: $attributes['title'],
      description: $attributes['description'],
      quantity: $attributes['quantity'],
      price: $attributes['price'],
      admin_id: $request->user()->id
    );

    // --- Service.
    try {
      $insertion = $this->service->insert($dto);
    } catch (InvalidAttributesException $e) {
      return ApiResponse::error(
        message: $e->getMessage(),
        code: 422
      );
    }

    // --- Response.
    return ApiResponse::success(
      data: new ProductResource($insertion),
      message: "Product {$attributes->title} successfuly inserted.",
      code: 201
    );
  }
}