<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductController
{
    /**
     * Display a listing of the resource.
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
        // Validate
        $data = $request->validated();
        // Store
        $status = Product::create($data);

        if (! $status)
            {
                return response()->json([
                    'status' => '200',
                    'message' => 'Process failed.',
                    'errors' => $request->messages()
                ]);
            }
        // Response
        return response()->json([
            'status' => '200',
            'message' => "Product {{$status->title}} succsesfully created."
        ]);
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
