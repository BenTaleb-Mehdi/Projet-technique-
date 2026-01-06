<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/users_test.csv');

        if (!file_exists($path)) {
            return;
        }

        $file = fopen($path, 'r');
        $headers = fgetcsv($file); // Skip headers

        while (($row = fgetcsv($file)) !== false) {
            [$username, $email] = $row;

            DB::table('users')->updateOrInsert(
                ['email' => $email],
                [
                    'name' => $username,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        fclose($file);
    }
}
