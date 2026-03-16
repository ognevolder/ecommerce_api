<?php

namespace App\Actions\CMS;

use App\Models\Log;

class LogProductInsertionAction
{
  public function execute($event)
  {
    Log::create([
      'user_id' => $event->admin_id,
      'type' => 'Admin CMS',
      'info' => "Product {$event->product->title} was inserted by {$event->admin_name}."
    ]);
  }
}