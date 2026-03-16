<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case AWAITING = 'Awaiting';
    case PAID = 'Paid';
    case REFUNDED = 'Refunded';
}
