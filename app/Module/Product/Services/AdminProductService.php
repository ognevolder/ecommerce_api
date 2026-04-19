<?php

namespace App\Module\Product\Services;

use App\Module\Product\DTOs\StoreProductDTO;
use App\Module\Product\DTOs\UpdateProductDTO;
use App\Module\Product\Enums\ProductStatus;
use App\Module\Product\Events\ProductInsertionEvent;
use App\Module\Product\Events\ProductUpdatedEvent;
use App\Module\Product\Exceptions\EmptyProductCollectionException;
use App\Module\Product\Exceptions\InvalidAttributesException;
use App\Module\Product\Exceptions\ProductNotFoundException;
use App\Module\Product\Models\Product;
use App\Presentation\Http\Resources\Product\ProductResource;

class AdminProductService
{
  /**
   * Index All Product models
   *
   * @return array
   */
  public function index(): array
  {
    // --- Action.
    // Fetch all Product models.
    $products = Product::paginate(16);
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
    $product = Product::where('id', $id)->first();
    if (! $product) {throw new ProductNotFoundException; }
    // --- Return.
    return $product;
  }

  public function store(StoreProductDTO $dto): Product
  {
    // --- Action.
    $product = Product::create([
      'title' => $dto->title,
      'description' => $dto->description,
      'quantity' => $dto->quantity,
      'price' => $dto->price
    ])->fresh();

    if (! $product) {
      throw new InvalidAttributesException();
    }

    // --- Event.
    event(new ProductInsertionEvent(
      product_title: $product->title,
      admin_id: $dto->admin_id
    ));

    // --- Return.
    return $product;
  }

  /**
   * Update Product data
   *
   * @param UpdateProductDTO $dto
   * @return Product
   */
  public function update(UpdateProductDTO $dto): Product
  {
    // --- Action.
    // Fetch Product.
    $product = Product::where('id', $dto->product_id)->first();
    // Update data.
    $product->update([
      'title' => $dto->attributes['title'],
      'description' => $dto->attributes['description'],
      'quantity' => $dto->attributes['quantity'],
      'price' => $dto->attributes['price'],
    ]);
    $product->fresh();

    // --- Event.
    event(new ProductUpdatedEvent(
      product_title: $product->title,
      admin_id: $dto->admin_id
    ));

    // --- Return.
    return $product;
  }

  public function publish(int $id): void
  {
    $product = Product::where('id', $id)->first();
    if (! $product) {
      throw new ProductNotFoundException;
    }

    $product->stateMachine()->transitionTo(ProductStatus::Public);
  }

  public function draft(int $id): void
  {
    $product = Product::where('id', $id)->first();
    if (! $product) {
      throw new ProductNotFoundException;
    }

    $product->stateMachine()->transitionTo(ProductStatus::Draft);
  }

  public function archive(int $id): void
  {
    $product = Product::where('id', $id)->first();
    if (! $product) {
      throw new ProductNotFoundException;
    }

    $product->stateMachine()->transitionTo(ProductStatus::Archived);
  }
}