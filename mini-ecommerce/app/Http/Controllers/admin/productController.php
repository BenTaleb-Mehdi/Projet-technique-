<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller {private $productService;
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
        
        if ($request->ajax()) {
            return view('admin.partials.rows', compact('products'));
        }
        
        return view('admin.partials.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        try {
            $data = $request->all();

            $data['user_id'] = auth()->id() ?? 1;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->hashName();
                $file->move(public_path('images'), $filename);
                $data['image_url'] = $filename;
            }

            $product = $this->productService->create($data);

            $product->load('categories');

            return view('admin.partials.row', compact('product'));

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|max:4096',
            'price' => 'required|numeric',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->hashName();
            $file->move(public_path('images'), $filename);
            $data['image_url'] = $filename;
        }

        $product = $this->productService->update($id, $data);

        return view('admin.partials.row', compact('product'));
    }

    public function destroy($id)
    {
        $this->productService->delete($id);
        return response()->json(['success' => true]);
    }
}