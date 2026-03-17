<?php

namespace App\Domain\Payment\Enums;

enum PaymentStatus: string
{
    case AWAITING = 'Awaiting';
    case PAID = 'Paid';
    case REFUNDED = 'Refunded';
}
