<?php

namespace App\Presentation\Http\Abstracts;

abstract class DefaultController
{
  protected abstract function policy();
  protected abstract function dto();
  protected abstract function service();
  protected abstract function response();
}