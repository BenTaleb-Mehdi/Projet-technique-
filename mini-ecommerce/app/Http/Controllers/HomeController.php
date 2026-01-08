<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProductService;

class HomeController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAll();
        return view('products.index', compact('products'));
    }

public function show($id)
{
    $product = $this->productService->find($id);
    
    // Make sure this path points to your full detail page
    return view('products.show', compact('product'));
}
}
