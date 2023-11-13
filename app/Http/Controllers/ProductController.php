<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function index(ProductRequest $request): JsonResponse
    {
        $request->validated();

        $products = $this->productRepository->getProducts(
            auth()->user(),
            $request->input('page_size', 10),
            $request->input('page', 1)
        );

        return response()->json($products);
    }

    public function show(int $productId): JsonResponse
    {
        $product = $this->productRepository->getProduct(auth()->user(), $productId);

        if (!$product) {
            abort(404, 'Not found');
        }

        return response()->json($product);
    }

    public function getInCategory(ProductRequest $request, int $categoryId): JsonResponse
    {
        Category::query()->findOrFail($categoryId);
        $request->validated();

        $products = $this->productRepository->getProductsInCategory(
            auth()->user(),
            $request->input('page_size', 10),
            $request->input('page', 1),
            $categoryId
        );

        return response()->json($products);
    }

    public function getFiltered(ProductFilterRequest $request): JsonResponse
    {
        $request->validated();

        $products = $this->productRepository->getFilteredProducts(
            auth()->user(),
            $request->input('page_size', 10),
            $request->input('page', 1),
            $request->input('order_by', 'name'),
            $request->input('order', 'asc'),
            $request->input('price_min'),
            $request->input('price_max'),
            $request->input('name'),
            $request->input('category_ids'),
        );

        return response()->json($products);
    }
}
