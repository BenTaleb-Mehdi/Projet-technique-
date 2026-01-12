<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ProductService(new Product());
    }

    public function test_it_can_get_all_products()
    {
        $result = $this->service->getAll();

        $this->assertGreaterThan(0, $result->total());
    }

    public function test_it_can_filter_products_by_title()
    {
        $result = $this->service->getAll([
            'search' => 'T-shirt'
        ]);

        $this->assertEquals(1, $result->total());
    }

    public function test_it_can_filter_products_by_category()
    {
        $product = Product::first();
        $category = Category::first();

        if (!$category) {
            $category = Category::create(['label' => 'Test Category']);
        }
        
        if (!$product) {
             $product = Product::create(['name' => 'Test Product', 'price' => 10, 'user_id' => 1]);
        }

        $this->assertNotNull($product);
        $this->assertNotNull($category);

        $product->categories()->syncWithoutDetaching([$category->id]);

        $result = $this->service->getAll([
            'category_id' => $category->id
        ]);

        $this->assertGreaterThan(0, $result->total());
    }


    public function test_it_can_update_a_product()
    {
        $product = Product::first();
        
        if (!$product) {
             $product = Product::create(['name' => 'To Update', 'price' => 10, 'user_id' => 1]);
        }

        $this->service->update($product->id, [
            'name' => 'Updated Name'
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name'
        ]);
    }

    public function test_it_can_delete_a_product()
    {
        $product = Product::first();
         
        if (!$product) {
             $product = Product::create(['name' => 'To Delete', 'price' => 10, 'user_id' => 1]);
        }

        $this->service->delete($product->id);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }
}