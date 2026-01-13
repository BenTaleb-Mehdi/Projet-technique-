<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductServiceTest extends TestCase
{
    use DatabaseTransactions;
    
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
        $this->assertEquals('T-shirt', $result->first()->name);
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

        $newName = 'Updated Name';

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
        $result = $this->service->getAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
      
        $this->assertNotNull($result->total());
    }

 
}