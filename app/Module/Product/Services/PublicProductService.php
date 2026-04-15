<?php

namespace App\Module\Product\Services;

use App\Module\Product\Exceptions\EmptyProductCollectionException;
use App\Module\Product\Exceptions\ProductNotFoundException;
use App\Module\Product\Models\Product;
use App\Presentation\Http\Resources\Product\ProductResource;

class PublicProductService
{
  public function index(): array
  {
    // --- Action.
    // Fetch all Product models with status 'Public'.
    $products = Product::where('status', 'public')->paginate(16);
    if ($products->isEmpty()) { throw new EmptyProductCollectionException; }
    // --- Return.
    return [
      'items' => ProductResource::collection($products),
      'pagination' => [
        'total' => $products->total(),
        'per_page' => $products->perPage(),
        'current_page' => $products->currentPage(),
        'last_page' => $products->lastPage(),
      ]
    ];
  }

  public function show(int $id): Product
  {
    // --- Action.
    $product = Product::where(['id' => $id, 'status' => 'public'])->first();
    if (! $product) {throw new ProductNotFoundException; }
    // --- Return.
    return $product;
  }
}