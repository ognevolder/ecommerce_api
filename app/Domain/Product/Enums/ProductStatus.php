<?php

namespace App\Domain\Product\Enums;

enum ProductStatus: string
{
  // - - - Availability.
  case AVAILABLE = 'available'; // Available.
  case RESERVED = 'reserved'; // Temporarily reserved.
  case BACKORDERED = 'backordered'; // Open to pre-order.
  case SOLD = 'sold'; // Out of stock.
}