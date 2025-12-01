<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin01',
            'email' => 'admin01@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'username' => 'teacher01',
            'email' => 'teacher01@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher'
        ]);

        User::create([
            'username' => 'student01',
            'email' => 'student01@example.com',
            'password' => Hash::make('password'),
            'role' => 'student'
        ]);
    }
}
