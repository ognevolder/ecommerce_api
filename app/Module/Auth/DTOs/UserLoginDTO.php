<?php

namespace App\Module\Auth\DTOs;

class UserLoginDTO
{
  public function __construct(
    public string $email,
    public string $password
  ) {}
}