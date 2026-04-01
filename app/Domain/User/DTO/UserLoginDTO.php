<?php

namespace App\Domain\User\DTO;

class UserLoginDTO
{
  public function __construct(
    public string $email,
    public string $password
  ) {}
}