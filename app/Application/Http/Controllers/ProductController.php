<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\Product\StoreProductRequest;
use App\Application\Http\Requests\UpdateProductRequest;
use App\Domain\Product\Models\Product;
use App\Application\Http\Responses\ApiResponse;
use App\Application\Http\Resources\ProductResource;
use App\Domain\Product\DTO\InsertProductDTO;
use App\Domain\Product\DTO\UpdateProductDTO;
use App\Domain\Product\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ProductController
{
    public function __construct(
        private ProductService $service
    ) {}

    /**
     * Відображення усіх моделей Product. | View all Product models.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Видобування всіх моделей Product із статусом 'Public'. | Fetch all Product models with status 'Public'.
        $products = Product::where('status', 'public')->paginate(16);
        // Колекція ProductResource із сторінками. | Paginated ProductResource Collection.
        $collection = [
            'items' => ProductResource::collection($products),
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]
        ];
        // Повернення JSON-відповіді. | Return JSON-response
        return ApiResponse::success($collection, "List of all Product models with status 'Public'.");
    }

    /**
     * Відображення моделі Product із обраним {id}. | View Product model with selected {id}.
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        // Повернення JSON-відповіді. | Return JSON-response
        return ApiResponse::success(new ProductResource($product), "Product model with selected ID: {$product->id}.");
    }

    /**
     * Внесення Product у таблицю. | Product insertion.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function insert(StoreProductRequest $request): JsonResponse
    {
        // Policy
        Gate::authorize('insert', Product::class);
        // DTO
        $dto = new InsertProductDTO(
            attributes: $request->validated(),
            admin_id: $request->user()->id,
            admin_name: $request->user()->name
            );
        // Service
        $product = $this->service->insert($dto);
        // Response
        return ApiResponse::success(
            data: new ProductResource($product),
            message: "Product {$product->title} was successfully inserted.",
            code: 201
            );
    }

    public function archive(Product $product): JsonResponse
    {
        // Policy
        Gate::authorize('archive', $product);
        // Service
        $result = $this->service->archive($product);
        if (! $result) {
            return ApiResponse::error(
                message: "Product archivation failed.",
                code: 422
            );
        }
        // Response
        return ApiResponse::success(
            data: new ProductResource($product),
            message: "Product {$product->title} was successfully archived.",
            code: 200
            );
    }

    /**
     * Публікація моделі Product. | Product model publishment.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    // public function publish(Product $product): JsonResponse
    // {

    // }


    /**
     * Редагування Product за обраним {id}. | Update Product model with selected {id}.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, int $product): JsonResponse
    {
        // Policy
        Gate::authorize('update', $product);
        // DTO
        $dto = new UpdateProductDTO(
            attributes: $request->validated(),
            admin_id: $request->user()->id,
            admin_name: $request->user()->name,
            product_id: $id
            );
        // Service
        $product = $this->service->update($dto);
        // Response
        return ApiResponse::success(
            data: new ProductResource($product),
            message: "Product {$product->title} was successfully updated.",
            code: 200
            );
    }
}
