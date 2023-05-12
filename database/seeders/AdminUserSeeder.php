<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    DB::table('users')->insert([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'email_verified_at' => now(),
        'password' => Hash::make('password'), // Set a password
        'is_admin' => true,
    ]);
}
}
