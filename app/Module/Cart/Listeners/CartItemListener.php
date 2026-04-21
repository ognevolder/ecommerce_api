<?php

namespace App\Module\Cart\Listeners;

use App\Module\Cart\Events\CartItemAdded;
use App\Module\Cart\Jobs\ReleaseProductJob;

class CartItemListener
{
  public function handle(CartItemAdded $event): void
  {
    ReleaseProductJob::dispatch($event)
    ->delay(now()->addMinutes(15))->onQueue('default');
  }
}