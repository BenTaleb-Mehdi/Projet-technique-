<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear cache bach maykonch machakil
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Create CRUD Permissions
        $permissions = [
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        // 3. Create Roles
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);
        $sellerRole  = Role::firstOrCreate(['name' => 'seller']);
        $visitorRole = Role::firstOrCreate(['name' => 'visitor']);

        // 4. Assign Permissions to Roles
        $adminRole->syncPermissions(['view-products', 'create-products', 'edit-products', 'delete-products']);
        $sellerRole->syncPermissions(['view-products', 'create-products', 'edit-products','delete-products']);
        $visitorRole->syncPermissions(['view-products']);

        // 5. Create Users & Assign Roles
        
        // Admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password123')]
        );
        $adminUser->assignRole($adminRole);

        // Seller
        $sellerUser = User::firstOrCreate(
            ['email' => 'seller@test.com'],
            ['name' => 'Seller User', 'password' => bcrypt('password123')]
        );
        $sellerUser->assignRole($sellerRole);

        // Visitor
        $visitorUser = User::firstOrCreate(
            ['email' => 'visitor@test.com'],
            ['name' => 'Visitor User', 'password' => bcrypt('password123')]
        );
        $visitorUser->assignRole($visitorRole);
        $path = database_path('seeders/data/products_test.csv');

        if (!file_exists($path)) return;

        $file = fopen($path, 'r');
        fgetcsv($file); 

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 6) continue;
            [$name, $description, $image_url, $price, $user_id, $category_label] = $row;

            $category = Category::firstOrCreate(['label' => $category_label]);

            $product = Product::updateOrCreate(
                ['name' => $name, 'user_id' => $user_id],
                [
                    'description' => $description,
                    'image_url' => $image_url,
                    'price' => $price,
                ]
            );

            
            $product->categories()->syncWithoutDetaching([$category->id]);
        }

        fclose($file);
    }
}
