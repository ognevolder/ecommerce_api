<?php

namespace App\Module\Order\Enums;

enum OrderStatus: string
{
  case New = 'new';
  case Pending = 'pending';
  case Fulfilled = 'fulfilled';
}