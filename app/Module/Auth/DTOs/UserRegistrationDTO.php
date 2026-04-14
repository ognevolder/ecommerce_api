<?php

namespace App\Module\Auth\DTOs;

class UserRegistrationDTO
{
  public function __construct(
    public string $name,
    public string $email,
    public string $password
  ) {}
}