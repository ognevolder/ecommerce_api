<?php

namespace App\Infrastructure\Logging\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
  protected $fillable = ['user_id', 'type', 'info'];
}
