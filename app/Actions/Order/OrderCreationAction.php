<?php

namespace App\Actions\Order;

use App\Models\Order;
use App\Models\User;

class OrderCreationAction
{
  public function execute(User $user): Order
  {
    return $user->orders()->create([
      'total_price' => 0,
      'status' => 'Pending',
      'payment_status' => 'Awaiting payment'
    ]);
  }
}