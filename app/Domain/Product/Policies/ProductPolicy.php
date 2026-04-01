<?php

namespace App\Domain\Product\Policies;

use App\Domain\Product\Models\Product;
use App\Domain\User\Models\User;

class ProductPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        return $user->isAdmin() ? true : null;
    }

    public function
}
