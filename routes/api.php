<?php

use App\Presentation\Http\Controllers\Auth\AuthenticationController;
use App\Presentation\Http\Controllers\Auth\LogoutController;
use App\Presentation\Http\Controllers\Auth\RegistrationController;
use App\Presentation\Http\Controllers\Cart\AddCartItemsController;
use App\Presentation\Http\Controllers\Cart\RemoveCartItemsController;
use App\Presentation\Http\Controllers\Product\ArchiveProductController;
use App\Presentation\Http\Controllers\Product\DraftProductController;
use App\Presentation\Http\Controllers\Product\IndexPrivateProductController;
use App\Presentation\Http\Controllers\Product\IndexPublicProductController;
use App\Presentation\Http\Controllers\Product\PublishProductController;
use App\Presentation\Http\Controllers\Product\ShowPrivateProductController;
use App\Presentation\Http\Controllers\Product\StoreProductController;
use App\Presentation\Http\Controllers\Product\ShowPublicProductController;
use App\Presentation\Http\Controllers\Product\UpdateProductController;
use Illuminate\Support\Facades\Route;

/**
 * - - - PUBLIC
 * 1. Authentication: Registration, Login.
 * 2. Product: Index, Show.
 */
Route::prefix('/v1')->group(function () {
  // --- Authentication.
  Route::middleware('throttle:3,1')->group(function () {
    Route::post('/registration', RegistrationController::class)->name('auth.registration');
    Route::post('/login', AuthenticationController::class)->name('auth.login');
  });
  // --- Product.
  Route::get('/products', IndexPublicProductController::class)->name('products.public.index');
  Route::get('/products/{id}', ShowPublicProductController::class)->name('products.public.show');
});

/**
 * - - - AUTHENTICATED
 * 1. Authentication: Logout, Terminate.
 * 2. Admin (Product CMS): Insert, Update, Archive, Publish, Draft.
 */
Route::middleware('auth:sanctum')->prefix('/v1')->group(function () {
  // --- Authentication.
  Route::get('/me', function () { echo "Gay"; })->name('profile');
  Route::post('/me/logout', LogoutController::class)->name('auth.logout');

  // --- Cart.
  Route::post('/cart/add', AddCartItemsController::class)->name('cart.add');
  Route::post('/cart/remove', RemoveCartItemsController::class)->name('cart.remove');

  // --- Admin.
  Route::prefix('/admin/products')->name('admin.products.')->group(function () {
    Route::get('/index', IndexPrivateProductController::class)->name('index');
    Route::get('/{product}', ShowPrivateProductController::class)->name('show');
    Route::post('/store', StoreProductController::class)->name('store');
    Route::patch('/update/{product}', UpdateProductController::class)->name('update');
    Route::patch('/publish/{id}', PublishProductController::class)->name('publish');
    Route::patch('/draft/{id}', DraftProductController::class)->name('draft');
    Route::patch('/archive/{id}', ArchiveProductController::class)->name('archive');
  });
});
