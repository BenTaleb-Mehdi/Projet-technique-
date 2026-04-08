<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;
    
    protected ProductService $service;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
    
        $this->service = new ProductService(new Product());

        $this->user = User::factory()->create();
    }

    public function test_it_can_get_all_products()
    {
        Product::factory()->count(10)->create(['user_id' => $this->user->id]);
      
        $result = $this->service->getAll();

        $this->assertEquals(10, $result->total());
    }

    public function test_it_can_filter_products_by_name()
    {
        $product = Product::factory()->create([
            'name' => 'Specific Product Name',
            'user_id' => $this->user->id
        ]);
        
        Product::factory()->count(5)->create(['user_id' => $this->user->id]);

        $result = $this->service->getAll([
            'search' => 'Specific Product Name'
        ]);

        $this->assertTrue($result->total() > 0);
        $this->assertEquals('Specific Product Name', $result->first()->name);
    }

    public function test_it_can_filter_products_by_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['user_id' => $this->user->id]);
        $product->categories()->attach($category);
        
        // Product without category
        Product::factory()->create(['user_id' => $this->user->id]);

        $result = $this->service->getAll([
            'category_id' => $category->id
        ]);

        $this->assertEquals(1, $result->total());
        $this->assertTrue($result->first()->categories->contains('id', $category->id));
    }

    public function test_it_can_update_a_product()
    {
        $product = Product::factory()->create(['user_id' => $this->user->id]);

        $newName = 'Updated Name ' . uniqid();

        $this->service->update($product->id, [
            'name' => $newName
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $newName
        ]);
    }

    public function test_it_returns_paginated_products()
    {
        Product::factory()->count(5)->create(['user_id' => $this->user->id]);
        
        $result = $this->service->getAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertNotNull($result->total());
    }
}