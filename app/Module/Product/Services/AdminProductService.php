<?php

namespace App\Module\Product\Services;

use App\Module\Product\DTO\InsertProductDTO;
use App\Module\Product\Events\ProductInsertionEvent;
use App\Module\Product\Exceptions\InvalidAttributesException;
use App\Module\Product\Models\Product;

class AdminProductService
{
  public function insert(InsertProductDTO $dto): Product
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
}




// public function update(UpdateProductDTO $dto): Product
//   {
//     return Product::update($dto->attributes);
//   }

//   public function archive(Product $product): Product
//   {
//     $product->stateMachine()->transitionTo(ProductStatus::ARCHIVED);
//     return $product->fresh();
//   }

//   public function publish(Product $product): Product
//   {
//     $product->stateMachine()->transitionTo(ProductStatus::PUBLIC);
//     return $product->fresh();
//   }

//   public function draft(Product $product): Product
//   {
//     $product->stateMachine()->transitionTo(ProductStatus::DRAFT);
//     return $product->fresh();
//   }