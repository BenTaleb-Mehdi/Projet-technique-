<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/category_product_test.csv');

        if (!file_exists($path)) {
            return;
        }

        $file = fopen($path, 'r');
        $headers = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            [$product_name, $category_label] = $row;

            $product = DB::table('products')->where('name', $product_name)->first();
            $category = DB::table('categories')->where('label', $category_label)->first();

            if ($product && $category) {
                DB::table('category_product')->updateOrInsert(
                    [
                        'product_id' => $product->id,
                        'category_id' => $category->id
                    ]
                );
            }
        }

        fclose($file);
    }
}
