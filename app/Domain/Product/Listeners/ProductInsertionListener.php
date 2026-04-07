<?php

namespace App\Domain\Product\Listeners;

use App\Domain\Product\Events\ProductInsertionEvent;
use App\Domain\Product\Jobs\LogProductInsertionJob;

class ProductInsertionListener
{
  public function handle(ProductInsertionEvent $event): void
  {
    $data = [
      'product_title' => $event->product_title,
      'admin_id' => $event->admin_id,
      'admin_name' => $event->admin_name
    ];

    LogProductInsertionJob::dispatch($data)->onQueue('low');
  }
}