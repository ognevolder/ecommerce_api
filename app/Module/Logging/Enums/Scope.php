<?php

namespace App\Module\Logging\Enums;

enum Scope: string
{
  case Auth = 'authentication';
  case Product = 'product';
}