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
       
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $p1 = Permission::firstOrCreate(['name' => 'manage-products']);
        $p2 = Permission::firstOrCreate(['name' => 'delete-product']);
        

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $sellerRole = Role::firstOrCreate(['name' => 'seller']);
        $visitorRole = Role::firstOrCreate(['name' => 'visitor']);

        $adminRole->syncPermissions(['manage-products', 'delete-product']);
        $sellerRole->syncPermissions(['manage-products']);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'),
            ]
        );
        $adminUser->assignRole($adminRole);

        $sellerUser = User::firstOrCreate(
            ['email' => 'seller@test.com'],
            [
                'name' => 'Seller User',
                'password' => bcrypt('password123'),
            ]
        );
        $sellerUser->assignRole($sellerRole);

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