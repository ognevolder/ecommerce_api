<?php

namespace App\Module\Product\DTOs;

class StoreProductDTO
{
  public function __construct(
    public string $title,
    public string $description,
    public int $quantity,
    public int $price,
    public int $admin_id
  ) {}
}