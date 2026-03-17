<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CMSController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/**
 * Public
 */

// --- AUTH
Route::post('/registration', [AuthController::class, 'register'])->name('auth.registration');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');


//Auth
Route::middleware('auth:sanctum')->group(function ()
{
  Route::patch('/order/{id}', [OrderController::class, 'update']);
  Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
  Route::post('/orders', [OrderController::class, 'store']);
  Route::get('/orders', [OrderController::class, 'index'])->name('user.orders');
  Route::patch('/order/cancel/{id}', [OrderController::class, 'cancel']);
});

Route::middleware(['auth:sanctum', 'cms'])->group(function ()
{
  // Create Product
  Route::post('/products', [CMSController::class, 'store']);
  // Update Product
  Route::patch('/product/{id}', [CMSController::class, 'store']);
  // Delete Product
  Route::delete('/product/{id}', [CMSController::class, 'destroy']);

  // Get Order
  Route::get('/admin/order/{id}', [AdminController::class, 'show']);
  // Get All Orders
  Route::get('/admin/orders', [AdminController::class, 'index']);
  // Fulfill order
  Route::patch('/admin/order/{id}', [AdminController::class, 'fulfill']);
  // Cancel order
  Route::patch('/admin/order/{id}', [OrderController::class, 'cancel']);
});