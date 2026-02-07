<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller {
    private $productService;
    private $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->getAll($request->all());
        $categories = $this->categoryService->getAll();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'productName'        => 'required|string|max:255',
            'productImage'       => 'nullable|image|max:2048',
            'productPrice'       => 'required|numeric',
            'productDescription' => 'required|string',
            'categories'         => 'nullable|array',
            'categories.*'       => 'exists:categories,id'
        ]);


        $data = [
            'name'        => $validated['productName'],
            'price'       => $validated['productPrice'],
            'description' => $validated['productDescription'],
            'user_id'     => auth()->id() ?? 1,
            'categories'  => $request->categories, 
        ];

        if ($request->hasFile('productImage')) {
            $data['image_url'] = $request->file('productImage')->store('products', 'public');
        }


        $product = $this->productService->create($data)->load('categories');

        return view('admin.products.partials.row', compact('product'));
    }


}