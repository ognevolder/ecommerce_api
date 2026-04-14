<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\Product\StoreRequest;
use App\Application\Http\Requests\UpdateProductRequest;
use App\Domain\Product\Models\Product;
use App\Application\Http\Responses\ApiResponse;
use App\Application\Http\Resources\ProductResource;
use App\Domain\Product\DTO\InsertProductDTO;
use App\Domain\Product\DTO\UpdateProductDTO;
use App\Domain\Product\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
/**
 *  --- Product Controller.
 * 1. Policy: bool|AuthorizationException.
 * 2. Request: DTO.
 * 3. Service: Product.
 * 4. Response: JSON.
 */
class ProductController
{
    public function __construct(
        private ProductService $service
    ) {}

    /**
     * Index all Product models.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // --- Service.
        $collection = $this->service->index();

        // --- Response.
        return ApiResponse::success($collection, "List of all Product models with status 'Public'.");
    }

    /**
     * Show Product model with selected {id}.
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        // --- Service.
        $product = $this->service->show($id);

        // --- Response.
        return ApiResponse::success(new ProductResource($product), "Product model with selected ID: {$product->id}.");
    }

    /**
     * Product insertion.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function insert(StoreRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        // --- Policy.
        Gate::authorize('insert', Product::class);

        // --- DTO.
        $dto = new InsertProductDTO(
            title: $attributes->title,
            description: $attributes->description,
            quantity: $attributes->quantity,
            price: $attributes->price,
            admin_id: $request->user()->id
            );

        // --- Service.
        $product = $this->service->insert($dto);

        // --- Response.
        return ApiResponse::success(
            data: new ProductResource($product),
            message: "Product {$product->title} was successfully inserted.",
            code: 201
            );
    }

    // public function archive(Product $product): JsonResponse
    // {
    //     // Policy
    //     Gate::authorize('archive', $product);
    //     // Service
    //     $result = $this->service->archive($product);
    //     if (! $result) {
    //         return ApiResponse::error(
    //             message: "Product archivation failed.",
    //             code: 422
    //         );
    //     }
    //     // Response
    //     return ApiResponse::success(
    //         data: new ProductResource($product),
    //         message: "Product {$product->title} was successfully archived.",
    //         code: 200
    //         );
    // }

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
    // public function update(UpdateProductRequest $request, int $product): JsonResponse
    // {
    //     // Policy
    //     Gate::authorize('update', $product);
    //     // DTO
    //     $dto = new UpdateProductDTO(
    //         attributes: $request->validated(),
    //         admin_id: $request->user()->id,
    //         admin_name: $request->user()->name,
    //         product_id: $id
    //         );
    //     // Service
    //     $product = $this->service->update($dto);
    //     // Response
    //     return ApiResponse::success(
    //         data: new ProductResource($product),
    //         message: "Product {$product->title} was successfully updated.",
    //         code: 200
    //         );
    // }
}
