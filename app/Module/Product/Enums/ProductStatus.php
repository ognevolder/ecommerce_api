<?php

namespace App\Module\Product\Enums;

enum ProductStatus: string
{
  // --- Insertion status.
  case Draft = 'draft'; // Insertion is not completed.
  case Public = 'public'; // Publicly accessible.
  case Archived = 'archived'; // Deleted or archived.
}