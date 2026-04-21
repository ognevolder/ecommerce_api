<?php

namespace App\Module\Cart\Models;

use App\Module\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class CartItem extends Model
{
  use HasFactory, SerializesModels;

  protected $fillable = ['cart_id', 'product_id', 'price', 'quantity', 'expires_at'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute(): int
    {
        return $this->price * $this->quantity;
    }
}