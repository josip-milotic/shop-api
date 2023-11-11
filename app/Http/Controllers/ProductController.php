<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        // TODO: change after implementing auth
        $user = auth()->user() ?: User::first();

        $productsList = $this->productRepository->getProductsForUser(
            $user,
            $request->input('page_size', 10),
            $request->input('page', 1)
        );

        return response()->json($productsList);
    }

    public function show(int $productId): JsonResponse
    {
        // TODO: change after implementing auth
        $user = auth()->user() ?: User::first();

        $product = $this->productRepository->getProductForUser($user, $productId);

        if (!$product) {
            abort(404, 'Not found');
        }

        return response()->json($product);
    }
}
