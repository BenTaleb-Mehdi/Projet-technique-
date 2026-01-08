<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAll()
    {
        return Product::with('category')->latest()->get();
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }
}
