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
            ['name' => 'Rafi Ardiansyah',   'email' => 'pelapor1@gmail.com',    'role' => 'pelapor'],
            ['name' => 'Irfan',       'email' => 'pelapor2@gmail.com',    'role' => 'pelapor'],
            ['name' => 'Aisy',    'email' => 'relawan@gmail.com',     'role' => 'relawan'],
            ['name' => 'Rayhan',       'email' => 'koordinator@gmail.com', 'role' => 'koordinator'],
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