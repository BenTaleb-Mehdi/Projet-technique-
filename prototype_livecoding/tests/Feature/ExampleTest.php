<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Services\ProductService;
use Mockery;
use Illuminate\Database\Eloquent\Collection;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $mockService = Mockery::mock(ProductService::class);
        $mockService->shouldReceive('getAll')->once()->andReturn(new Collection());

        $this->instance(ProductService::class, $mockService);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
