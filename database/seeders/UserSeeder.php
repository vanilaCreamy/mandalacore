<?php

namespace Database\Seeders;

use App\enum\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'role' => UserRole::ADMIN],
            // ['name' => 'Kevin Egy Mayo', 'email' => 'kevin@gmail.com', 'role' => UserRole::KEPALA],
            // ['name' => 'Fuza Nur Uswah Azizah', 'email' => 'pudja@gmail.com', 'role' => UserRole::PLOG],
            // ['name' => 'Dani Nugraha', 'email' => 'nugrahadani@gmail.com', 'role' => UserRole::PLOK],
            // ['name' => 'Mahesa Dwi Putra', 'email' => 'mahesa@gmail.com', 'role' => UserRole::ASLAP],
            // ['name' => 'Yogi Suryana', 'email' => 'yogi@gmail.com', 'role' => UserRole::DRIVER],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => $user['role'],
            ]);
        }
    }
}
