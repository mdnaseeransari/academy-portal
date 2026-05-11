<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    
    public function run(): void
    {
       User::updateOrCreate(
    ['email' => 'admin@optimal.com'],
    [
        'name' => 'Admin User',
        'password' => Hash::make('Optimal@666'),
        'role' => 'admin',
        'is_active' => true,
        'status' => 'approved',
    ]
);
    }
}
