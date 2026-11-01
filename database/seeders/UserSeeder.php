<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Rafi Ardiansyah',   'email' => 'pelapor1@example.com',    'role' => 'pelapor'],
            ['name' => 'Irfan',       'email' => 'pelapor2@example.com',    'role' => 'pelapor'],
            ['name' => 'Aisy',    'email' => 'relawan@example.com',     'role' => 'relawan'],
            ['name' => 'Rayhan',       'email' => 'koordinator@example.com', 'role' => 'koordinator'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'role' => $u['role'],
                    'password' => Hash::make('password'),
                ]
            );
        }
    }
}