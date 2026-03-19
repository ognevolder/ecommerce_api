<?php

namespace App\Domain\Product\Models;

use App\Domain\Product\Enums\ProductStatus;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'quantity', 'price', 'status'];
    protected $casts = ['status' => ProductStatus::class];
    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }

    // Availability on stock.
    public function availability(): int {
        return $this->quantity - $this->reserved;
    }
}
