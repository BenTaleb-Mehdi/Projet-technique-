<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;

class CategoryServiceTest extends TestCase
{
    protected CategoryService $service;

    protected function setUp(): void
    {
        parent::setUp(); 
        $this->service = new CategoryService(new Category());
    }

    public function test_it_can_get_all_categories()
    {
        $categories = $this->service->getAll();
        $this->assertGreaterThan(0, $categories->count());
    }
}