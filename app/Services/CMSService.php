<?php

namespace App\Services;

use App\Actions\CMS\InsertProductAction;
use App\DTO\CMS\InsertProductDTO;
use App\Events\CMS\ProductInserted;

class CMSService
{
  public function __construct(
    private InsertProductAction $insert
  ) {}

  public function insert(InsertProductDTO $dto)
  {
    // Product insertion
    $product = $this->insert->execute($dto->attributes);
    // Event
    event(new ProductInserted($product, $dto->admin_id, $dto->admin_name));
    // Return
    return $product;
  }
}