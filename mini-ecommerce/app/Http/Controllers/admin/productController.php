<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
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
        
        if ($request->ajax() && $request->wantsJson()) {
            return response()->json([
                'products' => $products->items(),
                'pagination' => (string) $products->links('vendor.pagination.custom')
            ]);
        }    
        return view('admin.index', compact('products', 'categories'));
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $data = $request->validated();

            $data['user_id'] = auth()->id() ?? 1;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->hashName();
                $file->move(public_path('images'), $filename);
                $data['image_url'] = $filename;
            }

            $product = $this->productService->create($data);

            $product->load('categories');

            if ($request->ajax()) {
                return response()->json($product);
            }

            return view('admin.partials.row', compact('product'));

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->hashName();
            $file->move(public_path('images'), $filename);
            $data['image_url'] = $filename;
        }

        $product = $this->productService->update($id, $data);
        $product->load('categories');

        if ($request->ajax()) {
            return response()->json($product);
        }

        return view('admin.partials.row', compact('product'));
    }

    public function destroy($id)
    {
        $this->productService->delete($id);
        return response()->json(['success' => true]);
    }
}