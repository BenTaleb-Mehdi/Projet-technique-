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

        $this->user = User::first();
    }

    public function test_it_can_get_all_products()
    {
  
      
        $result = $this->service->getAll();

        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_filter_products_by_name()
    {
        $existingProduct = Product::first();
        $this->assertNotNull($existingProduct, 'No products found in database to test with.');

        $result = $this->service->getAll([
            'search' => $existingProduct->name
        ]);

        $this->assertTrue($result->total() > 0);
        $this->assertEquals($existingProduct->name, $result->first()->name);
    }

    public function test_it_can_filter_products_by_category()
    {
        $productWithCategory = Product::has('categories')->with('categories')->first();
        $this->assertNotNull($productWithCategory, 'No products with categories found in database.');
        
        $category = $productWithCategory->categories->first();

        $result = $this->service->getAll([
            'category_id' => $category->id
        ]);

        $this->assertGreaterThan(0, $result->total());
        foreach ($result as $product) {
            $this->assertTrue($product->categories->contains('id', $category->id));
        }
    }

    public function test_it_can_update_a_product()
    {
        $product = Product::first();
        $this->assertNotNull($product, 'No product found to update.');

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
        $result = $this->service->getAll();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
      
        $this->assertNotNull($result->total());
    }

 
}