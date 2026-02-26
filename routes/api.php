<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

//Public
Route::post('/registration', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

//Auth
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function ()
{
  // Admin Dashboard
  Route::get('/admin', function ()
  {
    return response()->json([
      'message' => 'You entered into Admin Dashboard.',
      'status' => '200'
    ]);
  });
  // Create Product
  Route::post('/products', [ProductController::class, 'store']);
  // Update Product
  Route::patch('/product/{id}', [ProductController::class, 'store']);
  // Delete Product
  Route::delete('/product/{id}', [ProductController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->get('/profile', function ()
{
  return response()->json([
    'message' => 'You entered into Profile page.',
    'status' => '200'
  ]);
});