<?php

namespace App\Module\Cart\Shared;

use App\Module\Cart\Models\CartItem;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class CartDomainEvent
{
  use Dispatchable, SerializesModels;

  public $item;

  public function __construct(CartItem $item)
  {
    $this->item = $item;
  }
}