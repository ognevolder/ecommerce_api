<?php

namespace App\Domain\Order\Enums;

enum OrderStatus: string
{
  case NEW = 'new';
  case PENDING = 'pending';
  case FULFILLED = 'fulfilled';
  case CANCELED = 'canceled';
  case REFUNDED = 'refunded';
}
