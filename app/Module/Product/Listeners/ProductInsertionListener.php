<?php

namespace App\Module\Product\Listeners;

use App\Module\Product\Events\ProductInsertionEvent;
use App\Module\Product\Jobs\LogProductInsertionJob;

class ProductInsertionListener
{
  public function handle(ProductInsertionEvent $event): void
  {
    $data = [
      'product_title' => $event->product_title,
      'admin_id' => $event->admin_id
    ];

    LogProductInsertionJob::dispatch($data)->onQueue('low');
  }
}