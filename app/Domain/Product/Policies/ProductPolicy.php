<?php

namespace App\Domain\Product\Policies;

use App\Domain\Product\Models\Product;
use App\Domain\User\Models\User;

class ProductPolicy
{
    public function before(User $user, string $ability): bool|null {
        if ($user->isAdmin()) {
            return null;
        }
        return false;
    }

    public function insert(User $user): bool {
        return true;
    }

    // public function publish(User $user, Product $product): bool {
    //     // State machine
    // }

    // public function edit(User $user, Product $product): bool {
    //     // State machine
    // }

    // public function archive(User $user, Product $product): bool {
    //     // State machine
    // }
}
