<?php

namespace App\Domain\Product\Jobs;

use App\Domain\Product\Shared\ProductDomainJob;
use App\Infrastructure\Logging\Enums\Action;
use App\Infrastructure\Logging\Enums\Scope;
use App\Infrastructure\Logging\Models\Log;

class LogProductInsertionJob extends ProductDomainJob
{
  public function handle($data)
  {
    $product_title = $data['product_title'];
    $admin_id = $data['admin_id'];
    $admin_name = $data['admin_name'];

    Log::create([
      'user_id' => $admin_id,
      'scope' => Scope::PRODUCT,
      'action' => Action::INSERTION,
      'info' => "Product {$product_title} was inserted by {$admin_name}."
    ]);
  }
}