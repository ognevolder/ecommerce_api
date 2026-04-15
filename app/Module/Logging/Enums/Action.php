<?php

namespace App\Module\Logging\Enums;

enum Action: string
{
  // Auth
  case Registration = 'registration';
  case Login = 'login';
  case Logout = 'logout';

  case Insertion = 'insertion';
  case Editing = 'editing';
}