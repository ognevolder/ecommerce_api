<?php

namespace App\Module\Logging\Models;

use App\Module\Auth\Models\User;
use App\Module\Logging\Enums\Action;
use App\Module\Logging\Enums\Scope;
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
