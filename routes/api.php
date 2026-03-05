<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

//Public
Route::post('/registration', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

//Auth
Route::middleware('auth:sanctum')->group(function ()
{
  Route::middleware('auth:sanctum')->get('/profile', function ()
  {
    return response()->json([
      'message' => 'You entered into Profile page.',
      'status' => '200'
    ]);
  });
  Route::patch('/order/{id}', [OrderController::class, 'update']);
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::post('/orders', [OrderController::class, 'store']);
  Route::get('/orders', [OrderController::class, 'index']);
  Route::patch('/order/cancel/{id}', [OrderController::class, 'cancel']);
});

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

  // Get Order
  Route::get('/admin/order/{id}', [AdminController::class, 'show']);
  // Get All Orders
  Route::get('/admin/orders', [AdminController::class, 'index']);
  // Fulfill order
  Route::patch('/admin/order/{id}', [AdminController::class, 'fulfill']);
  // Cancel order
  Route::patch('/admin/order/{id}', [OrderController::class, 'cancel']);
});