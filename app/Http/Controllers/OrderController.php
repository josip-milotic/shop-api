<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function store(CreateOrderRequest $request, OrderService $orderService): JsonResponse
    {
        // TODO: change after implementing auth
        $user = auth()->user() ?: User::first();

        $order = $orderService->createOrder($user, $request->validated());

        return response()->json($order);
    }
}
