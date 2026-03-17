<?php

namespace App\Domain\Product\Models;

use App\Domain\Product\Enums\ProductState;
use App\Domain\Product\Enums\ProductStatus;
use App\Domain\Product\Exceptions\NotPublishableException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'stock', 'status', 'state'];
    protected $casts = [
            'status' => ProductStatus::class,
            'state' => ProductState::class
        ];

    // - - - State
    protected function isPublishable(): bool {
        return $this->state !== ProductState::PUBLIC;
    }

    protected function isArchivable(): bool {
        return $this->state !== ProductState::ARCHIVED;
    }

    protected function isDraft(): bool {
        return $this->state === ProductState::DRAFT;
    }

    // Availability on stock.
    protected function availability(): int {
        return $this->stock - $this->reserved;
    }

    // - - -
    // - - -
    public function publish(): void
    {
        // State
        if (! $this->isPublishable()) {
            throw new NotPublishableException();
        }
        // Stock
    }
}
