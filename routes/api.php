<?php

use App\Application\Http\Controllers\AuthController;
use App\Application\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/**
 * - - - PUBLIC
 * 1. Authentication: Registration, Login.
 * 2. Product: Index, Show.
 */
Route::prefix('/v1')->group(function () {
  // --- Authentication.
  Route::middleware('throttle:3,1')->group(function () {
    Route::post('/registration', [AuthController::class, 'register'])->name('auth.registration');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
  });
  // --- Product.
  Route::get('/products', [ProductController::class, 'index'])->name('products.index');
  Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
});

/**
 * - - - AUTHENTICATED
 * 1. Authentication: Logout, Terminate.
 * 2. Product: Insert, Update, Archive, Publish, Draft.
 */
Route::middleware('auth:sanctum')->prefix('/v1')->group(function () {
  // --- Authentication.
  Route::post('/me/logout', [AuthController::class, 'logout'])->name('auth.logout');
  Route::post('/me/terminate', [AuthController::class, 'terminate'])->name('auth.terminate');
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
