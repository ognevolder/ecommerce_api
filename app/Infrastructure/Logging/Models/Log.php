<?php

namespace App\Infrastructure\Logging\Models;

use App\Domain\User\Models\User;
use App\Infrastructure\Logging\Enums\Action;
use App\Infrastructure\Logging\Enums\Scope;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
  protected $fillable = ['user_id', 'scope', 'action', 'info'];

  protected $casts = [
    'scope' => Scope::class,
    'action' => Action::class
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
