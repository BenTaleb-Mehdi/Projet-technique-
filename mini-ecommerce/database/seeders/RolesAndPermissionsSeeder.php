<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset l-cache dial Spatie (Darouri!)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Create Permissions b tariqa safe
        $p1 = Permission::firstOrCreate(['name' => 'manage-products']);
        $p2 = Permission::firstOrCreate(['name' => 'delete-product']);
        

        // 3. Create Roles b tariqa safe
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $sellerRole = Role::firstOrCreate(['name' => 'seller']);
        $visitorRole = Role::firstOrCreate(['name' => 'visitor']);

        // 4. Assign Permissions l Roles
        // Admin 3ndo kolchi
        $adminRole->syncPermissions(['manage-products', 'delete-product']);

        // Seller 3ndo ghir manage-products
        $sellerRole->syncPermissions(['manage-products', 'delete-product']);

        // 5. Créer User Admin (Ila makanich)
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
            ]
        );
        $adminUser->assignRole($adminRole);

        // 6. (Optional) Créer User Seller bach t-testi bih
        $sellerUser = User::firstOrCreate(
            ['email' => 'seller@test.com'],
            [
                'name' => 'Seller User',
                'password' => bcrypt('password123'),
            ]
        );
        $sellerUser->assignRole($sellerRole);

        // 7. (Optional) Créer User Visitor bach t-testi bih
        $visitorUser = User::firstOrCreate(
            ['email' => 'visitor@test.com'],
            [
                'name' => 'Visitor User',
                'password' => bcrypt('password123'),
            ]
        );
        $visitorUser->assignRole($visitorRole);
    }
}