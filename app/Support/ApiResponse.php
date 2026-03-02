<?php

namespace App\Support;

class ApiResponse
{
  public static function success($data = null, string $message = 'Success', int $code = 200)
  {
    return response()->json([
      'success' => true,
      'message' => $message,
      'data' => $data,
    ], $code);
  }

  public static function error(string $message, int $code = 422)
  {
    return response()->json([
      'success' => false,
      'message' => $message
    ], $code);
  }
}