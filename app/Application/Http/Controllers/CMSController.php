<?php

namespace App\Application\Http\Controllers;

use App\Domain\Product\DTO\InsertProductDTO;
use App\Application\Http\Requests\CMS\StoreProductRequest;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Services\CMSService;
use App\Application\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\Gate;

class CMSController
{
    public function __construct(
        private CMSService $productInsertion
    ) {}

    /**
     * Відображення усіх елементів.
     */
    public function index()
    {
        // Fetch all products from DB
        $products = Product::all();
        // Return JSON-response
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // Policy
        if (! Gate::allows('create', Product::class))
            {
                throw new ApiException(message: "Only authorized Admin can insert Product.");
            }
        // DTO
        $dto = new InsertProductDTO(
            attributes: $request->validated(),
            admin_id: $request->user()->id,
            admin_name: $request->user()->name
            );
        // Service
        $product = $this->productInsertion->insert($dto);
        // Response
        return ApiResponse::success(
            message: "Product {$product->title} was successfully inserted.",
            code: 201
            );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch a product with ID
        $product = Product::where('id', $id)->first();
        // Response
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        //Fetch
        $item = Product::where('id', $id)->first();
        //Validate
        $data = $request->validated();
        //Update
        if (! $item)
            {
                return response()->json([
                    'status' => '200',
                    'message' => 'Process failed. Item is not exist.'
                ]);
            }

        $status = $item->update($data);
        //Response
        if (! $status)
            {
                return response()->json([
                    'status' => '200',
                    'message' => 'Process failed.',
                    'errors' => $request->messages()
                ]);
            }

        return response()->json([
            'status' => '200',
            'message' => "Product {{$status->title}} succsesfully updated."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Product::where('id', $id)->first();

        if (! $item)
            {
                return response()->json([
                    'status' => '200',
                    'message' => 'Process failed. Item is not exist.'
                ]);
            }

        $status = $item->delete();

        if ($status)
            {
                return response()->json([
                    'status' => '200',
                    'message' => "Product {{$item->title}} succsesfully deleted."
                ]);
            }
    }
}
