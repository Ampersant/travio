<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::create([
            'name' => 'Kevin Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), 
            'role_id' => 1, 
            'provider' => null,
            'provider_id' => null,
            'avatar_url' => 'http://127.0.0.1:8000/images/avatars/default.png',
            'remember_token' => Str::random(10),
        ]);

        // Create a default regular user
        User::create([
            'name' => 'Jhon User',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), 
            'role_id' => 2, 
            'provider' => null,
            'provider_id' => null,
            'avatar_url' => 'http://127.0.0.1:8000/images/avatars/default.png',
            'remember_token' => Str::random(10),
        ]);
    }
}
