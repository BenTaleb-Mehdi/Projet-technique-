<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Services\ProductService;
use Mockery;
use Illuminate\Database\Eloquent\Collection;

class ProductServiceTest extends TestCase
{
    protected $productMock;
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productMock = Mockery::mock(Product::class);
        $this->service = new ProductService($this->productMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_can_get_all_products()
    {
        $expectedCollection = new Collection(['p1', 'p2']);

        $this->productMock->shouldReceive('with')
            ->with('categories')
            ->once()
            ->andReturnSelf();
        
        $this->productMock->shouldReceive('latest')
            ->once()
            ->andReturnSelf();
        
        $this->productMock->shouldReceive('get')
            ->once()
            ->andReturn($expectedCollection);

        $result = $this->service->getAll();

        $this->assertEquals($expectedCollection, $result);
    }

    public function test_it_can_create_a_product()
    {
        $data = ['name' => 'New Product', 'price' => 100, 'categories' => [1, 2]];
        $createdProduct = Mockery::mock(Product::class);
        $relationMock = Mockery::mock();

        // Expect creation
        $this->productMock->shouldReceive('create')
            ->with(Mockery::subset(['name' => 'New Product', 'price' => 100]))
            ->once()
            ->andReturn($createdProduct);

        // Expect relationship handling on the created instance
        $createdProduct->shouldReceive('categories')->once()->andReturn($relationMock);
        $relationMock->shouldReceive('attach')->with([1, 2])->once();

        $result = $this->service->create($data);

        $this->assertEquals($createdProduct, $result);
    }

    public function test_it_can_find_a_product_by_id()
    {
        $id = 1;
        $foundProduct = new Product(['id' => $id]);

        $this->productMock->shouldReceive('findOrFail')
            ->with($id)
            ->once()
            ->andReturn($foundProduct);

        $result = $this->service->find($id);

        $this->assertEquals($foundProduct, $result);
    }

    public function test_it_can_update_a_product()
    {
        $id = 1;
        $data = ['name' => 'Updated Name', 'categories' => [3]];
        $productInstanceMock = Mockery::mock(Product::class);
        $relationMock = Mockery::mock();

        // Expect findOrFail
        $this->productMock->shouldReceive('findOrFail')
            ->with($id)
            ->once()
            ->andReturn($productInstanceMock);

        // Expect categories sync
        $productInstanceMock->shouldReceive('categories')->once()->andReturn($relationMock);
        $relationMock->shouldReceive('sync')->with([3])->once();

        // Expect update
        $productInstanceMock->shouldReceive('update')
            ->with(['name' => 'Updated Name'])
            ->once()
            ->andReturnTrue();

        $result = $this->service->update($id, $data);

        $this->assertEquals($productInstanceMock, $result);
    }

    public function test_it_can_delete_a_product()
    {
        $id = 1;
        $productInstanceMock = Mockery::mock(Product::class);
        $relationMock = Mockery::mock();

        // Expect findOrFail
        $this->productMock->shouldReceive('findOrFail')
            ->with($id)
            ->once()
            ->andReturn($productInstanceMock);
        
        // Expect category detach
        $productInstanceMock->shouldReceive('categories')->once()->andReturn($relationMock);
        $relationMock->shouldReceive('detach')->once();

        // Expect delete
        $productInstanceMock->shouldReceive('delete')
            ->once()
            ->andReturnTrue();

        $result = $this->service->delete($id);

        $this->assertTrue($result);
    }
}