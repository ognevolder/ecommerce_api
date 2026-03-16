<?php

namespace App\DTO\CMS;

use App\Models\User;

class InsertProductDTO
{
  public function __construct(
    public array $attributes,
    public int $admin_id,
    public string $admin_name
  ) {}
}