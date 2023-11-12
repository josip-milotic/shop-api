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

        $products = $this->productRepository->getProducts(
            $user,
            $request->input('page_size', 10),
            $request->input('page', 1)
        );

        return response()->json($products);
    }

    public function show(int $productId): JsonResponse
    {
        // TODO: change after implementing auth
        $user = auth()->user() ?: User::first();

        $product = $this->productRepository->getProduct($user, $productId);

        if (!$product) {
            abort(404, 'Not found');
        }

        return response()->json($product);
    }

    public function getInCategory(Request $request, int $categoryId): JsonResponse
    {
        // TODO: change after implementing auth
        $user = auth()->user() ?: User::first();

        $products = $this->productRepository->getProductsInCategory(
            $user,
            $request->input('page_size', 10),
            $request->input('page', 1),
            $categoryId
        );

        return response()->json($products);
    }

    public function getFiltered(Request $request): JsonResponse
    {
        // TODO: change after implementing auth
        $user = auth()->user() ?: User::first();

        $products = $this->productRepository->getFilteredProducts(
            $user,
            $request->input('page_size', 10),
            $request->input('page', 1),
            $request->input('order_by', 'id'),
            $request->input('order', 'asc'),
            $request->input('price_min'),
            $request->input('price_max'),
            $request->input('name'),
            $request->input('category_ids'),
        );

        return response()->json($products);
    }
}
