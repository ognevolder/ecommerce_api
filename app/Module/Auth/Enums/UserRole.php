<?php

namespace App\Module\Auth\Enums;

enum UserRole: string
{
  case Customer = 'customer';
  case Admin = 'admin';
  case Manager = 'manager';
  case Accountant = 'accountant';

  public function label(): string
  {
    return match ($this)
    {
      self::Customer => 'Customer',
      self::Admin => 'Administrator',
      self::Manager => 'Manager',
      self::Accountant => 'Accountant'
    };
  }
}