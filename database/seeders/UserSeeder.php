<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * UserSeeder - ZooSphere
 * Creates admin and demo user accounts
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@zoosphere.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'John Explorer',
            'email' => 'user@zoosphere.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
