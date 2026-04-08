<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CategoryService $service;

    protected function setUp(): void
    {
        parent::setUp(); 
        $this->service = new CategoryService(new Category());
    }

    public function test_it_can_get_all_categories()
    {
        Category::factory()->count(3)->create();

        $categories = $this->service->getAll();
        $this->assertEquals(3, $categories->count());
    }
}