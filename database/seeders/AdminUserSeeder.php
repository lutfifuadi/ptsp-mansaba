<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ptsp.com',
            'username' => 'admin',
            'password' => 'sangatrahasia123',
            'role' => 'admin',
        ]);
    }
}
