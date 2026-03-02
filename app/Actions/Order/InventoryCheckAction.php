<?php

namespace App\Actions\Order;

use App\Exceptions\ApiException;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InventoryCheckAction
{
  /**
   * Перевірка наявності та бронювання | Check availability and reserve
   *
   * @param array $items [['product_id' => 5, 'quantity' => 5], ...]
   * @return Collection <Product>
   * @throws ApiException "Product is out of stock"
   */
  public function execute(array $items): Collection
  {
    return DB::transaction(function () use ($items)
    {
      // Отримання продуктів | Get products
      $ids = collect($items)->pluck('product_id');
      $products = Product::whereIn('id', $ids)
        ->lockForUpdate()
        ->get()
        ->keyBy('id');

      // Перевірка наявності | Availability check
      foreach ($items as $item)
      {
        $product = $products[$item['product_id']] ?? null;

        if (!$product)
        {
          throw new ApiException($product, "Product is not found.");
        }

        if ($item['quantity'] > ($product->availability()))
        {
          throw new ApiException($product, "Product is out of stock.");
        }

        // Бронювання | Reservation
        $product->increment('reserved', $item['quantity']);
        }
    return $products;
    });
  }
}