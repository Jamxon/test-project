<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function buyurtmalar_royxatini_olish_mumkin()
    {
        Order::factory()->count(3)->create();

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function yangi_buyurtma_qoshish_mumkin()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id, 'price' => 500]);

        $response = $this->postJson('/api/orders', [
            'customer_name' => 'Ali',
            'order_date' => '2024-03-02',
            'status' => 'new',
            'comment' => 'Test',
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertStatus(201)
            ->assertJson(['customer_name' => 'Ali']);

        $this->assertDatabaseHas('orders', ['customer_name' => 'Ali']);
    }

    /** @test */
    public function buyurtmani_korish_mumkin()
    {
        $order = Order::factory()->create();

        $response = $this->getJson("/api/orders/{$order->id}");

        $response->assertStatus(200)
            ->assertJson(['customer_name' => $order->customer_name]);
    }

    /** @test */
    public function buyurtma_statusini_yangilash_mumkin()
    {
        $order = Order::factory()->create(['status' => 'new']);

        $response = $this->putJson("/api/orders/{$order->id}", [
            'status' => 'completed'
        ]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'completed']);

        $this->assertDatabaseHas('orders', ['status' => 'completed']);
    }

    /** @test */
    public function buyurtmani_ochirish_mumkin()
    {
        $order = Order::factory()->create();

        $response = $this->deleteJson("/api/orders/{$order->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
