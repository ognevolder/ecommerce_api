<?php

namespace App\Domain\User\DTO;

class UserRegistrationDTO
{
  public function __construct(
    public string $name,
    public string $email,
    public string $password
  ) {}
}