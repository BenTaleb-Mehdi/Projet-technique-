<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Services\ProductService;
use Mockery;
use Illuminate\Pagination\LengthAwarePaginator;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $mockService = Mockery::mock(ProductService::class);
        $paginator = new LengthAwarePaginator([], 0, 10);
        $mockService->shouldReceive('getAll')->once()->andReturn($paginator);

        $this->instance(ProductService::class, $mockService);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
