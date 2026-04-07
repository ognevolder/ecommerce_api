<?php

namespace App\Domain\Product\Policies;

use App\Domain\Product\Models\Product;
use App\Domain\User\Models\User;

class ProductPolicy
{
  public function before(User $user, string $ability): bool
  {
    return $user->isAdmin() ? true : null;
  }

  public function list(User $user, Product $product): bool
  {
    return true;
  }

  public function show(User $user, Product $product): bool
  {
    return true;
  }

  public function insert(User $user, Product $product): bool
  {
    return true;
  }
}
