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
  Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
});

/**
 * - - - AUTHENTICATED
 * 1. Log Out
 * 2. Insert Product
 * 3. Archive Product
 */
Route::middleware('auth:sanctum')->prefix('/v1')->group(function () {
  // --- Product
  // Insert
  Route::post('/products', [ProductController::class, 'insert'])->name('products.insert');
  // Edit
  Route::post('/products/{product}', [ProductController::class, 'update'])->name('products.update');
  // Archive (status)
  Route::patch('/products/archive/{product}', [ProductController::class, 'archive'])->name('products.archive');
  // Publish (status)
  Route::patch('/products/publish/{product}', [ProductController::class, 'publish'])->name('products.publish');
  // Draft (status)
  Route::patch('/products/draft/{product}', [ProductController::class, 'draft'])->name('products.draft');
});
