<?php

namespace App\Actions\CMS;

use App\Exceptions\ApiException;
use App\Models\Product;

class InsertProductAction
{
  public function execute(array $attributes): Product
  {
    $product = Product::create($attributes);
    if (! $product) {
      throw new ApiException(message: "Product insertion failed.", status: 422);
    }
    return $product;
  }
}