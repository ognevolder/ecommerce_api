<?php

namespace App\Domain\Product\DTO;

class UpdateProductDTO
{
  public function __construct(
    public array $attributes,
    public int $admin_id,
    public string $admin_name,
    public int $product_id
  ) {}
}