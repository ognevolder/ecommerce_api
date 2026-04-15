<?php

namespace App\Module\Product\Jobs;

use App\Module\Logging\Enums\Action;
use App\Module\Logging\Enums\Scope;
use App\Module\Logging\Models\Log;
use App\Module\Product\Shared\ProductDomainJob;

class LogProductInsertionJob extends ProductDomainJob
{
  public function handle($data)
  {
    $product_title = $data['product_title'];
    $admin_id = $data['admin_id'];

    Log::create([
      'user_id' => $admin_id,
      'scope' => Scope::Product,
      'action' => Action::Insertion,
      'info' => "Product {$product_title} was inserted by Admin [$admin_id]."
    ]);
  }
}