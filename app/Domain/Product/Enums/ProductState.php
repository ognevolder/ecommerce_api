<?php

namespace App\Domain\Product\Enums;

enum ProductState: string
{
  // - - - Insertion status.
  case DRAFT = 'draft'; // Insertion is not completed.
  case PUBLIC = 'public'; // Publicly accessible.
  case ARCHIVED = 'archived'; // Deleted or archived.
}