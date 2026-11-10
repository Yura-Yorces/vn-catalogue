<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'nickname' => 'Admin',
            'username' => 'admin123',
            'role' => User::ROLE_ADMIN,
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'nickname' => 'Moderator',
            'username' => 'mod123',
            'role' => User::ROLE_MODERATOR,
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'nickname' => 'User',
            'username' => 'user123',
            'role' => User::ROLE_USER,
            'password' => Hash::make('12345678'),
        ]);
    }
}
