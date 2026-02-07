<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(ProductService $product)
    {
        $products = $product->getAll();
        return view('products.index', compact('products'));
    }

    // Add this new method:
    public function show($id, ProductService $productService)
    {
        $product = $productService->find($id); // This uses your Service find() method
        return view('products.show', compact('product'));
    }
}
