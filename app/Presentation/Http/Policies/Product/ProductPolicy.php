<?php

namespace App\Presentation\Http\Policies\Product;

use App\Module\Auth\Enums\UserRole;
use App\Module\Auth\Models\User;
use App\Module\Product\Models\Product;

class ProductPolicy
{
  public function before(User $user, string $ability)
  {
    return $user->role === UserRole::Admin ? true : null;
  }

  public function viewAll(User $user): bool
  {
    return false;
  }

  public function show(User $user, Product $product): bool
  {
    return false;
  }

  public function store(User $user): bool
  {
    return false;
  }

  public function update(User $user, Product $product): bool
  {
    return false;
  }
}
