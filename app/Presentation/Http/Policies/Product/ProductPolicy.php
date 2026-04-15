<?php

namespace App\Module\Product\Policies;

use App\Module\Auth\Enums\UserRole;
use App\Module\Auth\Models\User;
use App\Module\Product\Models\Product;

class ProductPolicy
{
  public function insert(User $user): bool
  {
    return $user->role === UserRole::Admin ? true : false;
  }


  // public function list(User $user, Product $product): bool
  // {
  //   return true;
  // }

  // public function show(User $user, Product $product): bool
  // {
  //   return true;
  // }
}
