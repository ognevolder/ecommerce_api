<?php

namespace App\Domain\Product\Jobs;

use App\Infrastructure\Logging\Models\Log;

class LogProductInsertionJob
{
  public function execute($event)
  {
    Log::create([
      'user_id' => $event->admin_id,
      'type' => 'Product CMS',
      'info' => "Product {$event->product->title} was inserted by {$event->admin_name}."
    ]);
  }
}