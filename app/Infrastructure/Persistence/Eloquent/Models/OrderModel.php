<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use App\Domain\Order\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
  use HasFactory;

  protected $fillable = ['customer_id', 'total', 'status', 'expires_at'];

  protected function casts(): array
  {
    return [
      'status' => OrderStatus::class
    ];
  }
}