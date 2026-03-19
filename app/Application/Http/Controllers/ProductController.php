<?php

namespace App\Application\Http\Controllers;

use App\Application\Http\Requests\Product\StoreProductRequest;
use App\Domain\Product\Models\Product;
use App\Application\Http\Responses\ApiResponse;
use App\Application\Http\Resources\ProductResource;
use App\Domain\Product\DTO\InsertProductDTO;
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
    public function show($id): JsonResponse
    {
        // Видобування моделі Product із обраним {id} та статусом 'Public'. | Fetch Product model with selected {id} and status 'Public'.
        $product = Product::where('id', $id)->where('status', 'public')->first();
        // Повернення JSON-відповіді. | Return JSON-response
        return ApiResponse::success(new ProductResource($product), "Product model with selected {id}.");
    }

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

    /**
     * Публікація моделі Product. | Product model publishment.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    // public function store(StoreProductRequest $request): JsonResponse
    // {

    // }


    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateProductRequest $request, $id)
    // {
    //     //Fetch
    //     $item = Product::where('id', $id)->first();
    //     //Validate
    //     $data = $request->validated();
    //     //Update
    //     if (! $item)
    //         {
    //             return response()->json([
    //                 'status' => '200',
    //                 'message' => 'Process failed. Item is not exist.'
    //             ]);
    //         }

    //     $status = $item->update($data);
    //     //Response
    //     if (! $status)
    //         {
    //             return response()->json([
    //                 'status' => '200',
    //                 'message' => 'Process failed.',
    //                 'errors' => $request->messages()
    //             ]);
    //         }

    //     return response()->json([
    //         'status' => '200',
    //         'message' => "Product {{$status->title}} succsesfully updated."
    //     ]);
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     $item = Product::where('id', $id)->first();

    //     if (! $item)
    //         {
    //             return response()->json([
    //                 'status' => '200',
    //                 'message' => 'Process failed. Item is not exist.'
    //             ]);
    //         }

    //     $status = $item->delete();

    //     if ($status)
    //         {
    //             return response()->json([
    //                 'status' => '200',
    //                 'message' => "Product {{$item->title}} succsesfully deleted."
    //             ]);
    //         }
    // }
}
