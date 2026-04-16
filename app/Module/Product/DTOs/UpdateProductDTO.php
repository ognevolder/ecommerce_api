<?php

namespace App\Module\Product\DTOs;

class UpdateProductDTO
{
  public function __construct(
    public array $attributes,
    public int $admin_id,
    public int $product_id
  ) {}
}