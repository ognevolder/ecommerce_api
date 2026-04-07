<?php

namespace App\Domain\Product\Shared;

use App\Domain\Product\Models\Product;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class ProductDomainEvent
{
  use Dispatchable, SerializesModels;

  public $product_title;
  public $admin_id;
  public $admin_name;

  public function __construct(string $product_title, int $admin_id, string $admin_name)
  {
    $this->product_title = $product_title;
    $this->admin_id = $admin_id;
    $this->admin_name = $admin_name;
  }
}