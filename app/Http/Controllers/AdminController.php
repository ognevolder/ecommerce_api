<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::with('items.product')->paginate(10);

        return ApiResponse::success(OrderResource::collection($orders));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with('items.product')->find($id);
        return ApiResponse::success(new OrderResource($order));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id)
    {
        return DB::transaction(function () use ($id)
        {
            $order = Order::with('items.product')->where('id', $id)->firstOrFail();

            foreach ($order->items as $item)
                {
                    $product = $item->product;

                    $product->decrement('stock', $item->quantity);
                    $product->decrement('reserved', $item->quantity);
                }

            $order->update(['status' => 'Fulfilled']);

            return ApiResponse::success(new OrderResource($order->fresh()->load('items.product')), 'Замовлення опрацьоване.');
        });

    }
}
