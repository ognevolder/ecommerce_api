<?php

namespace App\Module\Cart\Models;

use App\Module\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

/**
 * Cart Aggregate root
 */
class Cart extends Model
{
  use HasFactory, SerializesModels;

  protected $fillable = ['user_id'];

  public function items()
  {
    return $this->hasMany(CartItem::class);
  }

  // --- Business Logic
  public function addProduct(Product $product, int $quantity): CartItem
  {
    // Fetch addProduct
    $item = $this->items()
      ->where('product_id', $product->id)
      ->first();

    // Increase || Create items
    if (! $item) {
      $item = $this->items()->create([
        'product_id' => $product->id,
        'price' => $product->price,
        'quantity' => $quantity
      ]);
    } else {
      $item->quantity += $quantity;
      $item->save();
    }

    return $item->refresh();
  }

  /**
   * Recalculate total
   *
   * @return void
   */
  public function getTotalAttribute(): int
  {
    return $this->relationLoaded('items')
      ? $this->items->sum(fn($item) => $item->total)
      : 0;
  }
}