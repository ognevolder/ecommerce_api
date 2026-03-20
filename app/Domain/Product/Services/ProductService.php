<?php

namespace App\Domain\Product\Services;

use App\Domain\Product\DTO\InsertProductDTO;
use App\Domain\Product\DTO\UpdateProductDTO;
use App\Domain\Product\Enums\ProductStatus;
use App\Domain\Product\Events\ProductInserted;
use App\Domain\Product\Models\Product;
/**
 *  --- Product Service.
 * 1. State machine: bool|DomainException.
 * 2. Action: Product|DomainException.
 * 3. Event: Event.
 * 4. Return: Product.
 */
class ProductService
{
  public function insert(InsertProductDTO $dto): Product
  {
    // Action
    $result = Product::create($dto->attributes);
    // Event
    event(new ProductInserted(
      product: $result,
      admin_id: $dto->admin_id,
      admin_name: $dto->admin_name
    ));
    // Return
    return $result;
  }

  public function update(UpdateProductDTO $dto): Product
  {
    return Product::update($dto->attributes);
  }

  public function archive(Product $product): Product
  {
    $product->stateMachine()->transitionTo(ProductStatus::ARCHIVED);
    return $product->fresh();
  }

  public function publish(Product $product): Product
  {
    $product->stateMachine()->transitionTo(ProductStatus::PUBLIC);
    return $product->fresh();
  }

  public function draft(Product $product): Product
  {
    $product->stateMachine()->transitionTo(ProductStatus::DRAFT);
    return $product->fresh();
  }
}