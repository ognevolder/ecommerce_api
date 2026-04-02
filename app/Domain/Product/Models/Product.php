<?php

namespace App\Domain\Product\Models;

use App\Domain\Product\Enums\ProductStatus;
use App\Domain\Product\StateMachines\ProductStateMachine;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class Product extends Model
{
    use HasFactory, SerializesModels;

    protected $fillable = ['title', 'description', 'quantity', 'price', 'status'];
    protected $casts = ['status' => ProductStatus::class];
    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }
    // --- State machine.
    public function stateMachine(): ProductStateMachine {
        return new ProductStateMachine($this);
    }

    // Availability on stock.
    public function availability(): int {
        return $this->quantity - $this->reserved;
    }
}
