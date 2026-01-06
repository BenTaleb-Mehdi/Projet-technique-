<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/products_test.csv');

        if (!file_exists($path)) return;

        $file = fopen($path, 'r');
        fgetcsv($file); // skip header

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 6) continue;

            [$name, $description, $image_url, $price, $user_id, $category_label] = $row;

            $category = Category::firstOrCreate(['label' => $category_label]);

            Product::updateOrCreate(
                ['name' => $name, 'user_id' => $user_id],
                [
                    'description' => $description,
                    'image_url' => $image_url,
                    'price' => $price,
                    'category_id' => $category->id,
                ]
            );
        }

        fclose($file);
    }
}
