<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
//    public function run(): void
//    {
//        // Admin user
//        User::create([
//            'name' => 'Admin User',
//            'email' => 'admin@gmail.com',
//            'password' => Hash::make('12345678'),
//            'phone' => '12345678',
//        ]);
//
//        // Regular user
//        User::create([
//            'name' => 'Regular User',
//            'email' => 'user@gmail.com',
//            'password' => Hash::make('12345678'),
//            'phone' => '12345678',
//        ]);
//    }
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'avatar' => 'backend/images/avtar/3.jpg',
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'role' => 'user',
            'password' => Hash::make('12345678'),
            'avatar' => 'backend/images/avtar/16.jpg',
        ]);
    }
}
