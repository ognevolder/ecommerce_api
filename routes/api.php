<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function ()
  {
    return response()->json([
      'message' => 'API works.',
      'status' => '200'
    ]);
  });

//Public
Route::post('/registration', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Auth
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);