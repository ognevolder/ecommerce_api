<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController
{
    public function __construct(
        private OrderService $service
    ) {}

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
    public function fulfill(int $id)
    {
        $order = $this->service->fulfill($id);
        return ApiResponse::success(new OrderResource($order), 'Замовлення успішно опрацьоване.');
    }
}
