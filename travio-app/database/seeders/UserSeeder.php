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
            'password' => Hash::make('password'), // change to a secure password
            'role_id' => 1, // assuming 1 is admin
            'provider' => null,
            'provider_id' => null,
            'avatar_url' => 'default.png',
            'remember_token' => Str::random(10),
        ]);

        // Create a default regular user
        User::create([
            'name' => 'Jhon User',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // change as needed
            'role_id' => 2, // default role
            'provider' => null,
            'provider_id' => null,
            'avatar_url' => 'default.png',
            'remember_token' => Str::random(10),
        ]);
    }
}
