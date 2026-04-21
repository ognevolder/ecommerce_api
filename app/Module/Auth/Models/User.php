<?php

namespace App\Module\Auth\Models;

use App\Module\Auth\Enums\UserRole;
use App\Module\Cart\Models\Cart;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\SerializesModels;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasFactory, Notifiable, HasApiTokens, SerializesModels;

  protected $fillable = ['name', 'password', 'email'];
  protected $hidden = ['password'];

  protected static function newFactory()
  {
    return UserFactory::new();
  }

  protected function casts(): array
  {
    return [
      'role' => UserRole::class,
      'password' => 'hashed'
    ];
  }

  public function cart(): HasOne
  {
    return $this->hasOne(Cart::class);
  }
}
