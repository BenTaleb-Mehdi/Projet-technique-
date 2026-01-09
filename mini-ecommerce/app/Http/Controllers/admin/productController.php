<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller {
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAll();
        $categories = Category::all();
       
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data = $request->all();

        $data['user_id'] = auth()->id() ?? 1; // Fallback to 1 if not logged in (for testing) or ensure login

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = $path;
        }

        $product = $this->productService->create($data);

        // This returns ONLY the HTML inside the row partial
        return view('admin.products.row', compact('product'));
    }
}