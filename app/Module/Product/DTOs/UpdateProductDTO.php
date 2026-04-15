<?php

namespace App\Module\Product\DTO;

class UpdateProductDTO
{
  public function __construct(
    public array $attributes,
    public int $admin_id,
    public int $product_id
  ) {}
}