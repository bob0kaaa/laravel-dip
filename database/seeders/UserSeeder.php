<?php

namespace Database\Seeders;

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
        User::create([
            'name' => 'test',
            'email' => 'test@test.ru',
            'password' => Hash::make('12345678'),
            'admin' => 0,
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@test.ru',
            'password' => Hash::make('admin'),
            'admin' => 1,
        ]);
    }
}
