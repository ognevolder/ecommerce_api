<?php

namespace App\Domain\Product\Services;

use App\Application\Http\Resources\ProductResource;
use App\Domain\Product\Models\Product;
/**
 *  --- Admin Service.
 * 1. State machine: bool|DomainException.
 * 2. Action: Product|DomainException.
 * 3. Event: Event.
 * 4. Return: ProductResource.
 */
class AdminService
{
  /**
   * List of all Product models from DB.
   *
   * @return array
   */
  public function list(): array
  {
    // --- Action.
    $products = Product::paginate(16);
    // Paginated ProductResource Collection.
    $collection = [
      'items' => ProductResource::collection($products),
      'pagination' => [
        'total' => $products->total(),
        'per_page' => $products->perPage(),
        'current_page' => $products->currentPage(),
        'last_page' => $products->lastPage(),
      ]
    ];
    // --- Return.
    return $collection;
  }

  public function show(int $id): Product
  {
    // --- Action.
    $product = Product::where('id', $id)->first();

    // --- Return.
    return $product;
  }
}