<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Mahsulotlar ro‘yxati.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Product::all(), 200);
    }

    /**
     * Mahsulot qo‘shish.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    /**
     * Bitta mahsulotni ko‘rish.
     */
    public function show(Product $product): \Illuminate\Http\JsonResponse
    {
        return response()->json($product, 200);
    }

    /**
     * Mahsulotni yangilash.
     */
    public function update(Request $request, Product $product): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category_id' => 'sometimes|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
        ]);

        $product->update($validated);

        return response()->json($product, 200);
    }

    /**
     * Mahsulotni o‘chirish.
     */
    public function destroy(Product $product): \Illuminate\Http\JsonResponse
    {
        $product->delete();
        return response()->json(['message' => 'Mahsulot o‘chirildi'], 200);
    }
}
