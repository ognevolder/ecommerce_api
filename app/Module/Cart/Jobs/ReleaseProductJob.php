<?php

namespace App\Module\Cart\Jobs;

use App\Module\Cart\Events\CartItemAdded;
use App\Module\Cart\Shared\CartDomainJob;
use Illuminate\Support\Facades\DB;

class ReleaseProductJob extends CartDomainJob
{
  public function __construct(
    protected CartItemAdded $event
  ) {}

  public function handle()
  {
    $item = $this->event->item;

    if (! $item) return;

    if ($item->expires_at > now()) return;

    DB::transaction(function () use ($item) {

      $product = $item->product()->lockForUpdate()->first();

      if (! $product) return;

      $product->decrement('reserved', $item->quantity);

      $item->delete();
    });
  }
}