<?php

namespace App\Module\Product\Shared;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class ProductDomainEvent
{
  use Dispatchable, SerializesModels;

  public $product_title;
  public $admin_id;

  public function __construct(string $product_title, int $admin_id)
  {
    $this->product_title = $product_title;
    $this->admin_id = $admin_id;
  }
}