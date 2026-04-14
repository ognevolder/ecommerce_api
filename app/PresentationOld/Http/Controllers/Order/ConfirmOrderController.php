<?php

namespace App\Presentation\Http\Controllers\Order;

use App\Presentation\Http\Abstracts\DefaultController;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class ConfirmOrderController extends DefaultController
{
  /**
   * Right for confirmation
   *
   * @return boolean|AuthorizationException
   */
  protected function policy(): bool|AuthorizationException
  {
    //
  }

  /**
   * Creating DTO
   *
   * @return void
   */
  protected function dto()
  {
    //
  }

  /**
   * Service
   *
   * @return void
   */
  protected function service()
  {
    //
  }

  /**
   * Response
   *
   * @return JsonResponse
   */
  protected function response(): JsonResponse
  {
    //
  }
}