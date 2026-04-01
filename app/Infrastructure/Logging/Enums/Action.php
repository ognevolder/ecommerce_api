<?php

namespace App\Infrastructure\Logging\Enums;

enum Action: string
{
  case REGISTRATION = 'registration';
  case LOGIN = 'login';
  case LOGOUT = 'logout';
  case TERMINATION = 'termination';
}