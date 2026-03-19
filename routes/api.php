<?php

use App\Application\Http\Controllers\AuthController;
use App\Application\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/**
 * - - - PUBLIC
 * 1. Authentication.
 * 2. Products.
 */
Route::prefix('/v1')->group(function () {
  // --- Authentication system.
  Route::post('/registration', [AuthController::class, 'register'])->name('auth.registration');
  Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
  // --- Product listing.
  Route::get('/products', [ProductController::class, 'index'])->name('products.index');
  Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
});

/**
 * - - - AUTHENTICATED
 * 1. Log Out
 * 2. Insert Product
 */
Route::middleware('auth:sanctum')->prefix('/v1')->group(function () {
  // --- Insert Product
  Route::post('/products', [ProductController::class, 'insert'])->name('products.insert');
});
