<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Buyurtmalar ro‘yxati.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Order::all(), 200);
    }

    /**
     * Buyurtma qo‘shish.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'order_date' => 'required|date',
            'status' => 'in:new,completed',
            'comment' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $validated['total_price'] = $validated['quantity'] * \App\Models\Product::find($validated['product_id'])->price;

        $order = Order::create($validated);

        return response()->json($order, 201);
    }

    /**
     * Bitta buyurtmani ko‘rish.
     */
    public function show(Order $order): \Illuminate\Http\JsonResponse
    {
        return response()->json($order, 200);
    }

    /**
     * Buyurtma statusini yangilash.
     */
    public function update(Request $request, Order $order): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:new,completed',
        ]);

        $order->update($validated);

        return response()->json($order, 200);
    }

    /**
     * Buyurtmani o‘chirish.
     */
    public function destroy(Order $order): \Illuminate\Http\JsonResponse
    {
        $order->delete();
        return response()->json(['message' => 'Buyurtma o‘chirildi'], 200);
    }
}
