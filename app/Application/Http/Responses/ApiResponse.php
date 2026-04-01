<?php

namespace App\Application\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
  public static function success($data = null, string $message = 'Success.', int $code = 200): JsonResponse
  {
    return response()->json([
      'success' => true,
      'message' => $message,
      'data' => $data,
    ], $code);
  }

  public static function error(string $message, int $code = 400): JsonResponse
  {
    return response()->json([
      'success' => false,
      'message' => $message
    ], $code);
  }
}