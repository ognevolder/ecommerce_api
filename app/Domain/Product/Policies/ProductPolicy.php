<?php

namespace App\Domain\Product\Policies;

use App\Domain\Product\Models\Product;
use App\Domain\User\Models\User;

class ProductPolicy
{
    // --- Внесення Product в таблицю. | Product insertion.
    public function insert(User $user): bool {
        return $user->isAdmin();
    }
    // --- Редагування Product. | Product editing.
    public function update(User $user, Product $product): bool {
        return $user->isAdmin();
    }
    // --- Зміна статусу на 'Public'. | Status update to 'Public'.
    public function publish(User $user, Product $product): bool {
        return $user->isAdmin();
    }
    // --- Зміна статусу на 'Draft'. | Status update to 'Draft'.
    public function draft(User $user, Product $product): bool {
        return $user->isAdmin();
    }
    // --- Зміна статусу на 'Archived'. | Status update to 'Archived'.
    public function archive(User $user, Product $product): bool {
        return $user->isAdmin();
    }
}
