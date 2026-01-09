<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
        
    }

    public function getAll()
    {
        return $this->product->with('categories')->latest()->get();
    }

    public function create(array $data)
    {
        $categories = $data['categories'] ?? []; 
        unset($data['categories']);

        $product = $this->product->create($data);
        $product->categories()->attach($categories);
        
        return $product;
    }

    public function find($id)
    {
        return $this->product->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $product = $this->find($id);
        
        if (isset($data['categories'])) {
            $product->categories()->sync($data['categories']);
            unset($data['categories']);
        }
        
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);
        $product->categories()->detach();
        return $product->delete();
    }
}
