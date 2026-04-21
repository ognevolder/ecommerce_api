<?php

namespace App\Module\Order\Models;

use App\Module\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class OrderItem extends Model
{
  use HasFactory, SerializesModels;

  protected $fillable = ['order_id', 'product_id', 'price', 'quantity'];

  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}