<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id' => Str::uuid(),
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'role' => 'super_admin',
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }
}
