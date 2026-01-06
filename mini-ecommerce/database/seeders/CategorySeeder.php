<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/categories_test.csv');

        if (!file_exists($path)) {
            return;
        }

        $file = fopen($path, 'r');
        $headers = fgetcsv($file); // Skip header

        while (($row = fgetcsv($file)) !== false) {
            [$label] = $row;

            DB::table('categories')->updateOrInsert(
                ['label' => $label],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        fclose($file);
    }
}
