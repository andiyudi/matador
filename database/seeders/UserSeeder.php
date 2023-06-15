<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Pengadaan',
                'username' => 'umum',
                'email' => 'umum@mail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
            ],
        ];
        User::insert($user);
    }
}
