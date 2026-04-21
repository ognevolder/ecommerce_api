<?php

namespace App\Module\Order\Models;

use App\Module\Auth\Models\User;
use App\Module\Order\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class Order extends Model
{
  use HasFactory, SerializesModels;

  protected $fillable = ['user_id', 'total', 'status', 'expires_at'];
  protected function casts(): array
  {
    return [
      'status' => OrderStatus::class
    ];
  }

  public function items()
  {
    return $this->hasMany(OrderItem::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}