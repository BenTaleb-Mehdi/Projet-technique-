<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/categories_test.csv');

        if (!file_exists($path)) return;

        $file = fopen($path, 'r');
        fgetcsv($file); // skip header

        while (($row = fgetcsv($file)) !== false) {
            [$label] = $row;

            Category::updateOrCreate(
                ['label' => $label],
                ['label' => $label]
            );
        }

        fclose($file);
    }
}
