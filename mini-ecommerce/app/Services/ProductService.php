<?php
namespace App\Services;

use App\Models\Product;


class ProductService
{
    public function getAll()
    {
        return Product::with('categories', 'user')->get();
    }

    public function store(array $data, int $userId)
    {
        return Product::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'image_url' => $data['image_url'] ?? null,
            'price' => $data['price'],
            'user_id' => $userId,
        ]);
    }

    public function delete(int $id)
    {
        return Product::destroy($id);
    }
}

