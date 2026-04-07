<?php

namespace App\Domain\Product\Services;

use App\Application\Http\Resources\ProductResource;
use App\Domain\Product\DTO\InsertProductDTO;
use App\Domain\Product\Events\ProductInsertionEvent;
use App\Domain\Product\Exceptions\InvalidAttributesException;
use App\Domain\Product\Models\Product;
use App\Domain\User\Models\User;

/**
 *  --- Admin Service.
 * 1. State machine: bool|DomainException.
 * 2. Action: Product|DomainException.
 * 3. Event: Event.
 * 4. Return: ProductResource.
 */
class AdminService
{
  /**
   * List of all Product models from DB.
   *
   * @return array
   */
  public function list(): array
  {
    // --- Action.
    $products = Product::paginate(16);
    // Paginated ProductResource Collection.
    $collection = [
      'items' => ProductResource::collection($products),
      'pagination' => [
        'total' => $products->total(),
        'per_page' => $products->perPage(),
        'current_page' => $products->currentPage(),
        'last_page' => $products->lastPage(),
      ]
    ];
    // --- Return.
    return $collection;
  }

  /**
   * Show Product model with selected ID.
   *
   * @param integer $id
   * @return Product
   */
  public function show(int $id): Product
  {
    // --- Action.
    $product = Product::where('id', $id)->first();

    // --- Return.
    return $product;
  }

  /**
   * Insert Product model.
   *
   * @param InsertProductDTO $dto
   * @return Product
   */
  public function insert(InsertProductDTO $dto): Product
  {
    $admin_name = User::where('id', $dto->admin_id)->first()->name;
    // --- Action.
    $product = Product::create([
      'title' => $dto->title,
      'description' => $dto->description,
      'quantity' => $dto->quantity,
      'price' => $dto->price
    ])->fresh();

    if (! $product) {
      throw new InvalidAttributesException();
    }

    // --- Event.
    event(new ProductInsertionEvent(
      product_title: $product->title,
      admin_id: $dto->admin_id,
      admin_name: $admin_name
    ));

    // --- Return.
    return $product;
  }
}