<?php

namespace App\Module\Cart\Services;

use App\Module\Cart\DTOs\CartServiceDTO;
use App\Module\Cart\DTOs\RemoveCartItemDTO;
use App\Module\Cart\Models\Cart;
use App\Module\Cart\Models\CartItem;
use App\Module\Product\Models\Product;

class CartService
{
  public function add(CartServiceDTO $dto): Cart
  {
    $cart = Cart::firstOrCreate([
      'user_id' => $dto->user_id
      ]);

    $product = Product::findOrFail($dto->product_id);

    $cart->addProduct($product, $dto->quantity);

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