<?php

namespace App\Domain\User\Models;

use App\Domain\Order\Models\Order;
use App\Domain\User\Enums\UserRole;
use App\Infrastructure\Logging\Models\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\SerializesModels;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SerializesModels;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'password' => 'hashed',
        'role' => UserRole::class
    ];


    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isManager(): bool
    {
        return $this->role === UserRole::MANAGER;
    }

    public function isCustomer(): bool
    {
        return $this->role === UserRole::CUSTOMER;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }
}
