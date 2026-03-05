<?php

namespace App\Enums;

enum OrderStatus: string
{
    case New = 'New';
    case Pending = 'Pending';
    case Fulfilled = 'Fulfilled';
    case Canceled = 'Canceled';
}
