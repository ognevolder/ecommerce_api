<?php

namespace App\Domain\Product\DTO;

class InsertProductDTO
{
  public function __construct(
    public array $attributes,
    public int $admin_id,
    public string $admin_name
  ) {}
}