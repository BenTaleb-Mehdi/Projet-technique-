<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Pagination\LengthAwarePaginator;
class ProductServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected ProductService $service;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ProductService(new Product());
        
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
    }

    public function test_it_can_get_all_products()
    {
        Product::create([
            'name' => 'Test Product',
            'price' => 100,
            'user_id' => $this->user->id
        ]);

        $result = $this->service->getAll();

        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_filter_products_by_title()
    {
        Product::create([
            'name' => 'T-shirt',
            'price' => 20,
            'user_id' => $this->user->id
        ]);

        $result = $this->service->getAll([
            'search' => 'T-shirt'
        ]);

        $this->assertEquals(1, $result->total());
    }

    public function test_it_can_filter_products_by_category()
    {
        $category = Category::create(['label' => 'Test Category']);
        $product = Product::create([
            'name' => 'Cat Product', 
            'price' => 10, 
            'user_id' => $this->user->id
        ]);

        $product->categories()->attach($category->id);

        $result = $this->service->getAll([
            'category_id' => $category->id
        ]);

        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_update_a_product()
    {
        $product = Product::create([
            'name' => 'To Update', 
            'price' => 10, 
            'user_id' => $this->user->id
        ]);

        $this->service->update($product->id, [
            'name' => 'Updated Name'
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name'
        ]);
    }
    public function test_it_returns_paginated_products()
    {
    
        for ($i = 1; $i <= 12; $i++) {
            Product::create([
                'name' => "Product $i",
                'price' => 100,
                'user_id' => $this->user->id
            ]);
        }
        $result = $this->service->getAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);

        $this->assertEquals(12, $result->total());

        $this->assertCount(10, $result->items());

        $this->assertTrue($result->hasMorePages());

    }
    public function test_it_can_delete_a_product()
    {
        $product = Product::create([
            'name' => 'To Delete', 
            'price' => 10, 
            'user_id' => $this->user->id
        ]);

        $this->service->delete($product->id);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
}