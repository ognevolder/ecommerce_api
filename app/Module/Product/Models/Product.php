<?php

namespace App\Module\Product\Models;

use App\Module\Product\Enums\ProductStatus;
use App\Module\Product\StateMachines\ProductStateMachine;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class Product extends Model
{
  use HasFactory, SerializesModels;

  protected $fillable = ['title', 'description', 'quantity', 'price', 'status'];

  protected function casts(): array
  {
    return [
      'role' => ProductStatus::class
    ];
  }

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
