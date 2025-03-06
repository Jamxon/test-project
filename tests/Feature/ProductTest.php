<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mahsulot_royxatini_olish_mumkin()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function yangi_mahsulot_qoshish_mumkin()
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/products', [
            'name' => 'Smartfon',
            'category_id' => $category->id,
            'description' => 'Yangi model',
            'price' => 1000
        ]);

        $response->assertStatus(201)
            ->assertJson(['name' => 'Smartfon']);

        $this->assertDatabaseHas('products', ['name' => 'Smartfon']);
    }

    /** @test */
    public function mahsulotni_korish_mumkin()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson(['name' => $product->name]);
    }

    /** @test */
    public function mahsulotni_yangilash_mumkin()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'Yangi nom'
        ]);

        $response->assertStatus(200)
            ->assertJson(['name' => 'Yangi nom']);

        $this->assertDatabaseHas('products', ['name' => 'Yangi nom']);
    }

    /** @test */
    public function mahsulotni_ochirish_mumkin()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
