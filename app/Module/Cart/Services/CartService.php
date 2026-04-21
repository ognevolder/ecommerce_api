<?php

namespace App\Module\Cart\Services;

use App\Module\Cart\DTOs\CartServiceDTO;
use App\Module\Cart\DTOs\RemoveCartItemDTO;
use App\Module\Cart\Events\CartItemAdded;
use App\Module\Cart\Models\Cart;
use App\Module\Product\Enums\ProductStatus;
use App\Module\Product\Exceptions\ProductNotFoundException;
use App\Module\Product\Exceptions\UnavailableProductException;
use App\Module\Product\Models\Product;

class CartService
{
  public function show(int $id): Cart
  {
    $cart = Cart::where('id', $id)->first();

    return $cart->load('items.product');
  }

  public function add(CartServiceDTO $dto): Cart
  {
    // Empty Cart
    $cart = Cart::firstOrCreate([
      'user_id' => $dto->user_id
      ]);

    // --- Product.
    $product = Product::where([
      'id' => $dto->product_id,
      'status' => ProductStatus::Public
    ])->first();

    if (! $product) {
      throw new ProductNotFoundException();
    }

    if ($product->availability() >= $dto->quantity) {
      $cart->addProduct($product, $dto->quantity);
      $product->increment('reserved', $dto->quantity);
    } else {
      throw new UnavailableProductException();
    }

    return $cart->load('items.product');
  }

  public function remove(RemoveCartItemDTO $dto): Cart
  {
    $cart = Cart::where('user_id', $dto->user_id)
      ->with('items')
      ->firstOrFail();

    $item = $cart->items()
      ->where('product_id', $dto->product_id)
      ->first();

    if (! $item) {
      return $cart;
    }

    if ($dto->quantity && $dto->quantity < $item->quantity) {
      $item->quantity -= $dto->quantity;
      $item->save();
    } else {
      $item->delete();
    }

    return $cart->load('items.product');
  }
}