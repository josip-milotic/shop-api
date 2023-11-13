<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function store(CreateOrderRequest $request, OrderService $orderService): JsonResponse
    {
        $order = $orderService->createOrder(auth()->user(), $request->validated());

        return response()->json($order);
    }
}
