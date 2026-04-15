<?php

namespace App\Module\Product\DTO;

class InsertProductDTO
{
  public function __construct(
    public string $title,
    public string $description,
    public int $quantity,
    public int $price,
    public int $admin_id
  ) {}
}