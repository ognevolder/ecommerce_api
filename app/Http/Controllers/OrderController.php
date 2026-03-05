<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class OrderController
{
    public function __construct(
        private OrderService $service
        ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::with('items.product')
            ->where('user_id', $request->user()->id)
            ->get();

        return ApiResponse::success(OrderResource::collection($orders));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = $this->service->create($request->user(), $request->validated('items'));
        return ApiResponse::success(new OrderResource($order), "Order created succsessfully.", 201);
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
    public function update($id)
    {
        $order = Order::where('id', $id)->firstOrFail();
        $order->update(['payment_status' => 'Paid']);
        return ApiResponse::success(new OrderResource($order), 'Оплата успішна.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cancel(Request $request, $order_id)
    {
        $order = $this->service->cancel($request->user()->id, $order_id);
        return ApiResponse::success(
          new OrderResource($order),
          'Замовлення скасовано.'
        );
    }
}
