<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/products_test.csv');

        if (!file_exists($path)) {
            return;
        }

        $file = fopen($path, 'r');
        $headers = fgetcsv($file); // skip headers

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 5) continue; // skip invalid rows

            [$name, $description, $image_url, $price, $user_id] = $row;

            DB::table('products')->updateOrInsert(
                ['name' => $name, 'user_id' => $user_id],
                [
                    'description' => $description,
                    'image_url' => $image_url,
                    'price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        fclose($file);
    }
}
