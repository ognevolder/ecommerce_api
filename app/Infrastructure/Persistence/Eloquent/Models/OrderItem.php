<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemModel extends Model
{
  use HasFactory;

  protected $fillable = ['order_id', 'product_id', 'price', 'quantity'];

  public function order(): BelongsTo
  {
    return $this->belongsTo(OrderModel::class);
  }
}