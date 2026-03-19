<?php

namespace App\Domain\Product\Services;

use App\Domain\Product\DTO\InsertProductDTO;
use App\Domain\Product\Models\Product;

class ProductService
{
  public function insert(InsertProductDTO $dto)
  {
    return Product::create($dto->attributes);
  }

  // public function publish(InsertProductDTO $dto)
  // {
  //   // Publi
  //   $product = $this->insert->execute($dto->attributes);
  //   // Product
  //   // Event
  //   event(new ProductInserted($product, $dto->admin_id, $dto->admin_name));
  //   // Return
  //   return $product;
  // }
}