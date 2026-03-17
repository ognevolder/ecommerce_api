<?php

namespace App\Domain\Order\Enums;

enum OrderStatus: string
{
    case New = 'New';
    case Pending = 'Pending';
    case Fulfilled = 'Fulfilled';
    case Canceled = 'Canceled';
}
